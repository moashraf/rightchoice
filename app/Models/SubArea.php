<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubArea extends Model
{
    use HasFactory;
             protected $table = 'subarea';
    protected $primaryKey = 'id';


    public $timestamps = false;

    protected $fillable = [
        'area',
        'area_en'
    ];
    public function aqars(){
        return $this->hasMany(aqar::Class);
    }
}
