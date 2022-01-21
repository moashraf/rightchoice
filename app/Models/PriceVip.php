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
        'views',
        'bgColor'
    ];
}
