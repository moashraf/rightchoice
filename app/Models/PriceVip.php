<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceVip extends Model
{
    use HasFactory;

    protected $table = 'price_vip';
    protected $primaryKey = 'id';

    protected $fillable = [
        'description',
        'description_en',
        'name',
        'name_en',
        'price',
        'discount_percentage',
        'views',
        'duration_days',
        'bgColor'
    ];

    protected $casts = [
        'discount_percentage' => 'integer',
        'duration_days' => 'integer',
    ];

    /**
     * All subscriptions ever purchased on this VIP package.
     */
    public function promotions()
    {
        return $this->hasMany(PropertyPromotion::class, 'price_vip_id');
    }
}
