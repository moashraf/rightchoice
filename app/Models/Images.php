<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    use HasFactory;
    protected $table = 'aqars_imgs';
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'img_url',
        'main_img',
        'aqar_id',
    ];
}
