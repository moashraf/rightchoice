<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
         'MOP',
         'status',
         'AGE',
         'TYPE',
         'Job_title',
        'Tax_card',
         'Commercial_Register',
         'Employee_Name',
         'profile_image',
         'phone_verfied_sms_status',
         'phone_sms_otp',
         'isAdmin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];





    public function prices()
    {
        return $this->belongsToMany(Pricing::Class, 'users_priceing_sale',
          'user_id', 'pricing_id');
    }

    public function wishlist()
    {
        return $this->hasMany(wish::class,'user_id','id');
    }
    public function companiess()
    {
        return $this->hasMany(Company::class,'user_id','id');
    }
     public function contact()
    {
        return $this->hasMany(UserContactAqar::class,'user_id','id');
    }

    public function userpricing()
    {
        return $this->hasMany(UserPriceing::class);
    }

    public function userpricin()
    {
        return $this->belongsTo(UserPriceing::class,'id','user_id')->orderBy('id','desc');
    }

    public function notification()
    {
        return $this->hasMany(Notification::class,'user_id','id');
    }

    public function views()
    {
        return $this->belongsToMany(aqar::class, 'viewers', 'user_id', 'aqar_id');
    }

}
