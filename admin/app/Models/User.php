<?php

namespace App\Models;

use App\Enums\UserStatusEnum;
use App\Enums\UserTypeEnum;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\priceing_sale;

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

    public function logActivities()
    {
        return $this->hasMany(LogActivity::class,'user_id');
    }

    public function views()
    {
        return $this->belongsToMany(aqar::class,'usercontactaqar','user_id','aqars_id');
    }
    
     public function viewers()
    {
        return $this->belongsToMany(users::class,'name','user_id','aqars_id');
    }
    public function UserPriceing(){
        
        return $this->belongsToMany(priceing_sale::class,'users_priceing_sale','user_id','pricing_id');
        // UserPriceing 
    } 

    public function getUserType()
    {
        if($this->TYPE == 1)
            return UserTypeEnum::Buyer;
        if($this->TYPE == 2)
            return UserTypeEnum::SALER;
        if($this->TYPE == 3)
            return UserTypeEnum::DEVELOPER;
        if($this->TYPE == 4)
            return UserTypeEnum::COMPANY;

    }

    public function getStatus()
    {
        if($this->status == 1)
            return UserStatusEnum::ACTIVE;
        if($this->status == 0)
            return UserStatusEnum::UNACTIVE;
    }
}
