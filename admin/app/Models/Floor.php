<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class Floor
 * @package App\Models
 * @version July 4, 2021, 1:51 pm UTC
 *
 * @property string $floor
 */
class Floor extends Model
{


    public $table = 'floor';




    public $fillable = [
        'floor'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'floor' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];


}
