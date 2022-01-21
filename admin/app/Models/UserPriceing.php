<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class UserPriceing
 * @package App\Models
 * @version July 15, 2021, 2:16 pm UTC
 *
 * @property integer $user_id
 * @property integer $pricing_id
 * @property integer $start_points
 * @property integer $current_points
 * @property integer $sub_points
 * @property integer $statues
 */
class UserPriceing extends Model
{


    public $table = 'users_priceing_sale';
    



    public $fillable = [
        'user_id',
        'pricing_id',
        'start_points',
        'current_points',
        'sub_points',
        'statues'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'pricing_id' => 'integer',
        'start_points' => 'integer',
        'current_points' => 'integer',
        'sub_points' => 'integer',
        'statues' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
