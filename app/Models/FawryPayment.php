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
