<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class compound
 * @package App\Models
 * @version July 4, 2021, 11:45 am UTC
 *
 * @property string $compound
 */
class compound extends Model
{


    public $table = 'compound';
    



    public $fillable = [
        'compound'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'compound' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
