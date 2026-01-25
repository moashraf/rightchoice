<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class mzaya
 * @package App\Models
 * @version July 11, 2021, 1:04 pm UTC
 *
 * @property string $mzaya_type
 * @property string $img_name
 */
class mzaya extends Model
{


    public $table = 'mzaya';
    



    public $fillable = [
        'mzaya_type',
        'img_name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'mzaya_type' => 'string',
        'img_name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
