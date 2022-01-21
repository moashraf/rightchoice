<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class RequestPhotoSession
 * @package App\Models
 * @version July 15, 2021, 12:17 pm UTC
 *
 * @property integer $user_id
 * @property string $phone
 * @property string $email
 * @property string $user_name
 * @property string $address
 * @property string $description
 */
class RequestPhotoSession extends Model
{


    public $table = 'requestphotosession';
    



    public $fillable = [
        'user_id',
        'phone',
        'email',
        'user_name',
        'address',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'phone' => 'string',
        'email' => 'string',
        'user_name' => 'string',
        'address' => 'string',
        'description' => 'string'
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
