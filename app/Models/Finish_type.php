<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finish_type extends Model
{
    use HasFactory;

    protected $table = 'finish_type';
    protected $primaryKey = 'id';

    protected $fillable = [
        'finish_type',
        'finish_type_en'
    ];
    public function aqars(){
        return $this->hasMany(aqar::Class);
    }
}
