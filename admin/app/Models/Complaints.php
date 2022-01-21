<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class Complaints
 * @package App\Models
 * @version July 15, 2021, 2:27 pm UTC
 *
 * @property integer $user_id
 * @property integer $aqar_id
 * @property string $message
 */
class Complaints extends Model
{


    public $table = 'complaints';
    



    public $fillable = [
        'user_id',
        'aqars_id',
        'message'
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

    public function userinfo()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function aqarinfo()
    {
        return $this->belongsTo(aqar::class, 'aqars_id');
    }
}
