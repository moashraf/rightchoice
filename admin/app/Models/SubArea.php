<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class subarea
 * @package App\Models
 * @version July 5, 2021, 8:44 am UTC
 *
 * @property string $area
 */
class subarea extends Model
{


    public $table = 'subarea';
    



    public $fillable = [
        'area'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'area' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
