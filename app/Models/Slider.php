<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;
    protected $table = 'slider';
    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'sub_title',
        'description',
        'image',
        'title_en',
        'sub_title_en',
        'description_en',
    ];

}