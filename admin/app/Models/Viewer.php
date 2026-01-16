<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Viewer extends Model
{
    use HasFactory;
      
      
    public $table = 'viewers';

    
     public $fillable = [
        'user_id',
        'aqar_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'aqar_id' => 'string'
    ];
    
    
    public function user()
    {
        return $this->belongsTo(User::class );
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
        if($this->status == 2)
            return UserStatusEnum::UNACTIVE;
    }
}
