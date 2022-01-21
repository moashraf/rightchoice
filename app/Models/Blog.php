<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $table = 'blogs';
    protected $primaryKey = 'id';

    protected $fillable = [
        'single_photo',
        'title',
        'title_en',
        'seo_title',
        'seo_title_en',
        'meta_description',
        'meta_description_en',
        'slug',
        'slug_en',
        'status',
        'canonical',
        'canonical_en',
        'number_of_visits',
        'description',
        'description_en',
        'main_img_alt',
        'main_img_alt_en',
        'body'
        
    ];
}
