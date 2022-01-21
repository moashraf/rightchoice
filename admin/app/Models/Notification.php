<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class Notification
 * @package App\Models
 * @version July 18, 2021, 8:39 am UTC
 *
 * @property integer $user_id
 * @property boolean $type
 * @property string $title
 * @property string $message
 */
class Notification extends Model
{


    public $table = 'notifications';
    



    public $fillable = [
        'user_id',
        'type',
        'title',
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
        'type' => 'boolean',
        'title' => 'string'
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

    
}
