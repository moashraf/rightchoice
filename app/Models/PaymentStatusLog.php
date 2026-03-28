<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentStatusLog extends Model
{
    public $timestamps = false;

    protected $table = 'payment_status_logs';

    protected $fillable = [
        'payment_id',
        'event_type',
        'old_status',
        'new_status',
        'message',
        'payload',
        'performed_by',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function payment()
    {
        return $this->belongsTo(FawryPayment::class, 'payment_id');
    }

    public function performer()
    {
        return $this->belongsTo(User::class, 'performed_by');
    }
}
