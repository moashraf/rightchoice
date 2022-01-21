<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPriceing extends Model
{
    use HasFactory;
    protected $table = 'users_priceing_sale';

    protected $fillable = [
        'user_id',
        'pricing_id',
        'start_points',
        'current_points',
        'sub_points',
        'statues',
    ];
    
    public function pricing()
    {
        return $this->belongsTo(Pricing::class,'pricing_id');
    }
}
