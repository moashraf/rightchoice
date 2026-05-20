<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AqarDeleteReason extends Model
{
    use HasFactory;

    protected $table = 'aqar_delete_reasons';

    protected $fillable = [
        'title_ar',
        'title_en',
        'image',
    ];
}

