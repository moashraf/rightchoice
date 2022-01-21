<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class UserContactAqar
 * @package App\Models
 * @version July 15, 2021, 1:40 pm UTC
 *
 * @property integer $user_id
 * @property integer $aqars_id
 */
class UserContactAqar extends Model
{


    public $table = 'usercontactaqar';
    



    public $fillable = [
        'user_id',
        'aqars_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'aqars_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
