<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentNote extends Model
{
    protected $table = 'payment_notes';

    protected $fillable = [
        'payment_id',
        'admin_id',
        'note',
    ];

    public function payment()
    {
        return $this->belongsTo(FawryPayment::class, 'payment_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
