<?php

namespace App\Models;

use App\Enums\RefundStatusEnum;
use Illuminate\Database\Eloquent\Model;

class PaymentRefund extends Model
{
    protected $table = 'payment_refunds';

    protected $fillable = [
        'payment_id',
        'user_id',
        'refund_amount',
        'refund_status',
        'refund_reason',
        'refund_reference_number',
        'gateway_response',
        'admin_id',
        'admin_note',
        'approved_at',
        'rejected_at',
        'refunded_at',
    ];

    protected $casts = [
        'refund_amount' => 'decimal:2',
        'approved_at'   => 'datetime',
        'rejected_at'   => 'datetime',
        'refunded_at'   => 'datetime',
    ];

    // ── Relationships ────────────────────────────────────────────────

    public function payment()
    {
        return $this->belongsTo(FawryPayment::class, 'payment_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    // ── Accessors ────────────────────────────────────────────────────

    public function getStatusLabelAttribute(): string
    {
        return RefundStatusEnum::label($this->refund_status ?? '');
    }

    public function getStatusBadgeAttribute(): string
    {
        return RefundStatusEnum::badge($this->refund_status ?? '');
    }
}
