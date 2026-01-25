<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Viewer extends Model
{
    use HasFactory;


    public $table = 'viewers';


     public $fillable = [
        'user_id',
        'aqar_id',
        'points'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'aqar_id' => 'integer',
         'points' => 'integer'

    ];
     public function aqars(){
        return $this->hasMany(aqar::Class);
    }


       public function logActivities()
    {
        return $this->hasMany(LogActivity::class,'id');
    }

    public function views()
    {
        return $this->belongsToMany( users::class,'id','name');
    }
    public function UserPriceing(){

        return $this->belongsToMany(PriceingSale::class,'users_priceing_sale','user_id','pricing_id');
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
