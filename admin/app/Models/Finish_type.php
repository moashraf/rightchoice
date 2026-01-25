<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class finish_type
 * @package App\Models
 * @version July 4, 2021, 1:31 pm UTC
 *
 * @property string $finish_type
 */
class finish_type extends Model
{


    public $table = 'finish_type';
    



    public $fillable = [
        'finish_type'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'finish_type' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
