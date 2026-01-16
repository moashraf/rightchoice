<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class priceing_sale
 * @package App\Models
 * @version July 11, 2021, 12:33 pm UTC
 *
 * @property string $type
 * @property string $description
 * @property number $price
 * @property integer $points
 * @property string $desc1
 * @property string $desc2
 * @property string $desc3
 * @property string $color
 * @property string $title_color
 * @property string $bk_color
 */
class priceing_sale extends Model
{


    public $table = 'priceing_sale';
    



    public $fillable = [
        'type',
        'description',
        'price',
        'points',
        'desc1',
        'desc2',
        'desc3',
        'color',
        'title_color',
        'bk_color'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'type' => 'string',
        'description' => 'string',
        'price' => 'double',
        'points' => 'integer',
        'desc1' => 'string',
        'desc2' => 'string',
        'desc3' => 'string',
        'color' => 'string',
        'title_color' => 'string',
        'bk_color' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
