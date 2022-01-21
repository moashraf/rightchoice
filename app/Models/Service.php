<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $table = 'services';
    protected $primaryKey = 'id';

    protected $fillable = [
        'Service',
        'Service_en',
        'slug',
        'slug_en',
        'title',
        'title_en',
        'description',
        'description_en',
        'image',
    ];

    public function companies(){
        return $this->hasMany(Company::Class);
    }
}
