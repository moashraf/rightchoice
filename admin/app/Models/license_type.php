<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class license_type
 * @package App\Models
 * @version July 4, 2021, 2:10 pm UTC
 *
 * @property string $license_type
 */
class license_type extends Model
{


    public $table = 'license_type';
    



    public $fillable = [
        'license_type'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'license_type' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
