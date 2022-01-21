<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestPhotoSession extends Model
{
    use HasFactory;
    protected $table = 'requestphotosession';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'phone',
        'email',
        'user_name',
        'address',
        'description',
    ];

}