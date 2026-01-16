<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class call_time
 * @package App\Models
 * @version July 4, 2021, 11:38 am UTC
 *
 * @property string $call_time
 */
class call_time extends Model
{


    public $table = 'call_time';
    



    public $fillable = [
        'call_time'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'call_time' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
