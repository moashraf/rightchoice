<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Represents a customer's subscription to a VIP package on a specific property.
 *
 * One row per (user, aqar, price_vip, payment). Lets us answer:
 *   - Which ad a customer chose to feature when they subscribed to a VIP package
 *     (useful when the customer owns multiple ads).
 *   - Full history of every promotion for a given property or customer.
 */
class PropertyPromotion extends Model
{
    use HasFactory;

    protected $table = 'property_promotions';

    public const STATUS_PENDING   = 'pending';
    public const STATUS_ACTIVE    = 'active';
    public const STATUS_EXPIRED   = 'expired';
    public const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'user_id',
        'aqar_id',
        'price_vip_id',
        'fawry_payment_id',
        'status',
        'amount_paid',
        'duration_days',
        'started_at',
        'expires_at',
        'cancelled_at',
        'notes',
    ];

    protected $casts = [
        'amount_paid'   => 'decimal:2',
        'duration_days' => 'integer',
        'started_at'    => 'datetime',
        'expires_at'    => 'datetime',
        'cancelled_at'  => 'datetime',
    ];

    // ── Relationships ────────────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function aqar()
    {
        return $this->belongsTo(aqar::class, 'aqar_id');
    }

    public function package()
    {
        return $this->belongsTo(PriceVip::class, 'price_vip_id');
    }

    public function payment()
    {
        return $this->belongsTo(FawryPayment::class, 'fawry_payment_id');
    }

    // ── Scopes ───────────────────────────────────────────────────────

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeExpired($query)
    {
        return $query->where('status', self::STATUS_EXPIRED);
    }

    // ── Helpers ──────────────────────────────────────────────────────

    /**
     * Record (or refresh) a pending promotion when a VIP payment is initiated.
     *
     * We upsert on (user, aqar, package, payment) so that if the checkout is
     * retried we don't create duplicate pending rows for the same payment.
     */
    public static function recordPending(
        int $userId,
        int $aqarId,
        int $priceVipId,
        ?int $fawryPaymentId,
        float $amount,
        int $durationDays
    ): self {
        $attributes = [
            'user_id'          => $userId,
            'aqar_id'          => $aqarId,
            'price_vip_id'     => $priceVipId,
            'fawry_payment_id' => $fawryPaymentId,
        ];

        $values = [
            'status'        => self::STATUS_PENDING,
            'amount_paid'   => $amount,
            'duration_days' => $durationDays,
        ];

        return static::updateOrCreate($attributes, $values);
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE
            && $this->expires_at
            && $this->expires_at->isFuture();
    }

    public function markActive(int $durationDays, ?int $paymentId = null, ?float $amountPaid = null): void
    {
        $startedAt = now();

        $this->fill([
            'status'           => self::STATUS_ACTIVE,
            'duration_days'    => $durationDays,
            'started_at'       => $startedAt,
            'expires_at'       => $startedAt->copy()->addDays($durationDays),
            'fawry_payment_id' => $paymentId ?? $this->fawry_payment_id,
            'amount_paid'      => $amountPaid ?? $this->amount_paid,
        ])->save();
    }

    public function markExpired(): void
    {
        $this->update(['status' => self::STATUS_EXPIRED]);
    }

    public function markCancelled(?string $note = null): void
    {
        $this->update([
            'status'       => self::STATUS_CANCELLED,
            'cancelled_at' => now(),
            'notes'        => $note ?? $this->notes,
        ]);
    }
}
