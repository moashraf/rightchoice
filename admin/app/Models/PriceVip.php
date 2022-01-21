<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class PriceVip
 * @package App\Models
 * @version July 15, 2021, 12:12 pm UTC
 *
 * @property string $name
 * @property number $price
 * @property string $description
 * @property integer $views
 */
class PriceVip extends Model
{


    public $table = 'price_vip';
    



    public $fillable = [
        'name',
        'price',
        'description',
        'views'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'price' => 'double',
        'views' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
