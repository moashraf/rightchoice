<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserContactAqar extends Model
{
    use HasFactory;

    protected $table = 'usercontactaqar';
    protected $primaryKey = 'id';

    public $fillable = [
        'user_id',
        'aqars_id',
    ];




public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }



public function all_aqat_viw()
    {
        return $this->belongsTo(Aqar::class,'aqars_id')->distinct();
    }




}
