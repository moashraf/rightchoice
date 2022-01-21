<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Governrate extends Model
{
    use HasFactory;
     protected $table = 'governrate';
    protected $primaryKey = 'id';

    protected $fillable = [
        'governrate',
        'governrate_en'
    ];
    public function aqars(){
        return $this->hasMany(aqar::Class);
    }
    
    public function districts(){
        return $this->hasMany(District::Class, 'govern_id');
    }
}
