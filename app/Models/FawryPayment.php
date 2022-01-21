<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FawryPayment extends Model
{
    use HasFactory;
    
    
        protected $table = 'fawryPayment';
    protected $primaryKey = 'id';

    protected $fillable = [
        'paymentAmount',
        'tmyezz_price_vip_id',
        'user_id',
        'paymentStatus',
         'signature',
        'paymentMethod',
        'referenceNumber',
        'paqaat_priceing_sale_id',
        'merchantRefNumber'
    ];



}
