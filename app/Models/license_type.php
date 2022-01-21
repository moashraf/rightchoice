<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class license_type extends Model
{
    use HasFactory;

    protected $table = 'license_type';
    protected $primaryKey = 'id';

    protected $fillable = [
        'license_type',
        'license_type_en'
    ];
}
