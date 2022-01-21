<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calltime extends Model
{
    use HasFactory;

    protected $table = 'call_time';

    protected $primaryKey = 'id';

    protected $fillable = [
        'call_time',
        'call_time_en',
    ];

   

    
}
