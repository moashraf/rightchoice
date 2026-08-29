<?php

namespace App\Models;

use App\Enums\PaymentStatusEnum;
use App\Enums\RefundStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FawryPayment extends Model
{
    use HasFactory;

    protected $table = 'fawryPayment';
    protected $primaryKey = 'id';

    protected $fillable = [
        'paymentAmount',
        'currency',
        'tmyezz_price_vip_id',
        'user_id',
        'paymentStatus',
        'signature',
        'paymentMethod',
        'transaction_type',
        'referenceNumber',
        'paqaat_priceing_sale_id',
        'merchantRefNumber',
        'paid_at',
        'gateway_response',
        'callback_payload',
        'failure_reason',
        'gateway_fees',
        'net_amount',
        'refunded_amount',
        'refund_status',
    ];

    protected $casts = [
        'paymentAmount'   => 'decimal:2',
        'gateway_fees'    => 'decimal:2',
        'net_amount'      => 'decimal:2',
        'refunded_amount' => 'decimal:2',
        'paid_at'         => 'datetime',
    ];

    // ── Relationships ────────────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function priceVip()
    {
        return $this->belongsTo(PriceVip::class, 'tmyezz_price_vip_id');
    }

    public function pricingSale()
    {
        return $this->belongsTo(priceing_sale::class, 'paqaat_priceing_sale_id');
    }

    public function refunds()
    {
        return $this->hasMany(PaymentRefund::class, 'payment_id');
    }

    public function statusLogs()
    {
        return $this->hasMany(PaymentStatusLog::class, 'payment_id');
    }

    public function notes()
    {
        return $this->hasMany(PaymentNote::class, 'payment_id');
    }

    /**
     * The VIP promotion subscription this payment funded (if any).
     * Present only for VIP/tmyezz payments — buyer point-package payments
     * will not have a linked promotion.
     */
    public function propertyPromotion()
    {
        return $this->hasOne(PropertyPromotion::class, 'fawry_payment_id');
    }

    // ── Accessors ────────────────────────────────────────────────────

    public function getStatusLabelAttribute(): string
    {
        return PaymentStatusEnum::label($this->paymentStatus ?? '');
    }

    public function getStatusBadgeAttribute(): string
    {
        return PaymentStatusEnum::badge($this->paymentStatus ?? '');
    }

    public function getRefundStatusLabelAttribute(): ?string
    {
        return $this->refund_status ? RefundStatusEnum::label($this->refund_status) : null;
    }

    public function getRefundStatusBadgeAttribute(): ?string
    {
        return $this->refund_status ? RefundStatusEnum::badge($this->refund_status) : null;
    }

    public function getPackageNameAttribute(): string
    {
        if ($this->paqaat_priceing_sale_id && $this->pricingSale) {
            return $this->pricingSale->type ?? ('باقة #' . $this->paqaat_priceing_sale_id);
        }
        if ($this->tmyezz_price_vip_id && $this->priceVip) {
            return $this->priceVip->name ?? ('VIP #' . $this->tmyezz_price_vip_id);
        }
        return '-';
    }

    /**
     * True if this payment is a seller VIP (property promotion) payment.
     */
    public function isSellerVip(): bool
    {
        return (int) ($this->tmyezz_price_vip_id ?? 0) > 0;
    }

    /**
     * The aqar (property) the customer chose to promote with this payment.
     *
     * Resolution order:
     *   1) the dedicated property_promotions row (preferred, new flow)
     *   2) gateway_response JSON (older payments before property_promotions existed)
     *
     * Returns null for non-VIP payments and when the aqar cannot be resolved.
     */
    public function resolveTargetAqar(): ?aqar
    {
        if (!$this->isSellerVip()) {
            return null;
        }

        $promotion = $this->relationLoaded('propertyPromotion')
            ? $this->propertyPromotion
            : $this->propertyPromotion()->with('aqar:id,title,title_en,slug,slug_en')->first();

        if ($promotion && $promotion->aqar) {
            return $promotion->aqar;
        }

        $aqarId = $this->extractAqarIdFromGateway();

        if (!$aqarId) {
            return null;
        }

        return aqar::query()
            ->select(['id', 'title', 'title_en', 'slug', 'slug_en'])
            ->find($aqarId);
    }

    /**
     * Parse the aqar_id embedded in gateway_response / callback_payload for
     * legacy VIP payments that predate the property_promotions table.
     */
    private function extractAqarIdFromGateway(): ?int
    {
        $raw = trim((string) $this->gateway_response);

        if ($raw !== '') {
            $decoded = json_decode($raw, true);
            if (is_array($decoded) && isset($decoded['aqar_id']) && is_numeric($decoded['aqar_id'])) {
                return (int) $decoded['aqar_id'];
            }

            foreach (preg_split('/\r?\n/', $raw) as $line) {
                $line = rtrim($line, ", \t\r\n");
                if ($line === '' || $line[0] !== '{') {
                    continue;
                }
                $item = json_decode($line, true);
                if (is_array($item) && isset($item['aqar_id']) && is_numeric($item['aqar_id'])) {
                    return (int) $item['aqar_id'];
                }
            }
        }

        $callback = json_decode((string) $this->callback_payload, true);
        if (is_array($callback)) {
            $profileId = (string) ($callback['customerMerchantId'] ?? $callback['customerProfileId'] ?? '');
            if ($profileId !== '' && str_contains($profileId, '55555')) {
                $pieces = explode('55555', $profileId, 2);
                if (count($pieces) === 2 && ctype_digit($pieces[1])) {
                    return (int) $pieces[1];
                }
            }
        }

        return null;
    }

    // ── Helper Methods ───────────────────────────────────────────────

    public function isPaid(): bool
    {
        return $this->paymentStatus === PaymentStatusEnum::PAID;
    }

    public function canRefund(): bool
    {
        return $this->isPaid()
            && !in_array($this->refund_status, [RefundStatusEnum::REFUNDED, RefundStatusEnum::REQUESTED, RefundStatusEnum::UNDER_REVIEW])
            && $this->refunded_amount < $this->paymentAmount;
    }

    public function getRefundableAmount(): float
    {
        return max(0, $this->paymentAmount - $this->refunded_amount);
    }

    /**
     * Recalculate net_amount and refund_status from related refunds.
     */
    public function recalculateRefunds(): void
    {
        $totalRefunded = $this->refunds()
            ->where('refund_status', RefundStatusEnum::REFUNDED)
            ->sum('refund_amount');

        $this->refunded_amount = $totalRefunded;
        $this->net_amount = $this->paymentAmount - $totalRefunded - $this->gateway_fees;

        if ($totalRefunded >= $this->paymentAmount) {
            $this->refund_status = RefundStatusEnum::REFUNDED;
        } elseif ($totalRefunded > 0) {
            $this->refund_status = 'partially_refunded';
        }

        $this->save();
    }

    /**
     * Log a status change event.
     */
    public function logStatusChange(string $eventType, ?string $oldStatus, ?string $newStatus, ?string $message = null, $payload = null, ?int $performedBy = null): void
    {
        $this->statusLogs()->create([
            'event_type'   => $eventType,
            'old_status'   => $oldStatus,
            'new_status'   => $newStatus,
            'message'      => $message,
            'payload'      => is_array($payload) ? json_encode($payload) : $payload,
            'performed_by' => $performedBy,
        ]);
    }
}
