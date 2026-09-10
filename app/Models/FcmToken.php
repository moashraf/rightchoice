<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FcmToken extends Model
{
    protected $fillable = ['token', 'user_id'];

    protected $hidden = ['token'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
