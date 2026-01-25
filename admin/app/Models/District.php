<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class district
 * @package App\Models
 * @version July 4, 2021, 12:32 pm UTC
 *
 * @property string $district
 * @property integer $govern_id
 */
class district extends Model
{


    public $table = 'district';
    



    public $fillable = [
        'district',
        'govern_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'district' => 'string',
        'govern_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
