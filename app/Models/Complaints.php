<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Complaints extends Model
{
    use HasFactory;

    const COMPLAINT_PENDING    = 1;
    const COMPLAINT_INPROGRESS = 2;
    const COMPLAINT_SOLVED     = 3;

    protected $table = 'complaints';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'aqars_id',
        'message',
        'status',
    ];

    public function userinfo()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function aqarinfo()
    {
        return $this->belongsTo(\App\Models\aqar::class, 'aqars_id');
    }

}