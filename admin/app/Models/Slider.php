<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class Slider
 * @package App\Models
 * @version July 15, 2021, 1:37 pm UTC
 *
 * @property string $title
 * @property string $sub_title
 * @property string $description
 * @property string $image
 */
class Slider extends Model
{


    public $table = 'slider';
    



    public $fillable = [
        'title',
        'sub_title',
        'description',
        'image'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'sub_title' => 'string',
        'image' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
