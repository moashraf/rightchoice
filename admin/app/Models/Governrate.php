<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class governrate
 * @package App\Models
 * @version July 4, 2021, 12:05 pm UTC
 *
 * @property string $governrate
 */
class governrate extends Model
{


    public $table = 'governrate';
    



    public $fillable = [
        'governrate'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'governrate' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
