<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;
         protected $table = 'district';
    protected $primaryKey = 'id';

    protected $fillable = [
        'district',
        'govern_id',
        'district_en'
    ];
    public function aqars(){
        return $this->hasMany(aqar::Class);
    }
     public function governrates()
    {
        return $this->belongsToMany(Governrate::class);
    }
}
