<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pricing extends Model
{
    use HasFactory;

    
    protected $table = 'priceing_sale';

    protected $primaryKey = 'id';

    protected $fillable = [
        'type',
        'description',
        'price',
        'discount_percentage',
        'points',
        'desc1',
        'desc2',
        'desc3',
        'color',
        'title_color',
        'bk_color',
        'type_en',
        'description_en',
    ];

    protected $casts = [
        'price' => 'float',
        'discount_percentage' => 'integer',
    ];

    public function users()
    {
        return $this->belongsToMany(User::Class, 'users_priceing_sale', 
          'user_id', 'pricing_id');
    }

}
