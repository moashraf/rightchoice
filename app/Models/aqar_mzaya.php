<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class aqar_mzaya
 * @package App\Models
 * @version July 15, 2021, 9:47 am UTC
 *
 * @property integer $mzaya_id
 * @property integer $aqar_id
 */
class aqar_mzaya extends Model
{


    public $table = 'aqar_mzaya';
    



    public $fillable = [
        'mzaya_id',
        'aqar_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'mzaya_id' => 'integer',
        'aqar_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
