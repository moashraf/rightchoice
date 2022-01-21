<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    use HasFactory;
       
    protected $table = 'pages';

    protected $primaryKey = 'id';

    protected $fillable = [
        'page_name',
        'description',
        'page_name_en',
        'description_en'
          ];
}
