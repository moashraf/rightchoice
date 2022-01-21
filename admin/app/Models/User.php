<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_image',
        'MOP',
        'AGE',
        'TYPE',
        'status',
        'Tax_card',
        'Job_title',
        'Employee_Name',
        'isAdmin',
        'Commercial_Register',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function rules($password,$id = null)
    {
        return [
            'email'            => "required|email|unique:users,email," . $id,
            'password'         =>( $password != null ? 'min:6' : ''),
            'MOP'            => "required|numeric|phone_number|unique:users,MOP," . $id,
        ];
    }
    
    public function typeRet($type){
            
            return 'hello';
    }
}
