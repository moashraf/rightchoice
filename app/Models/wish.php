<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class wish extends Model
{
    use HasFactory;


    protected $table = 'wish_list';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'aqars_id',  ];


       

public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function aqarInfo()
    {
        return $this->belongsTo(aqar::class,'aqars_id');
    }

}
