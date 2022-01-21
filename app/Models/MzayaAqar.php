<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MzayaAqar extends Model
{
    use HasFactory;
    
    protected $table = 'aqar_mzaya';
    public $timestamps = true;
       protected $fillable = [
        'mzaya_id',
        'aqar_id'
             ];


             

             
}
