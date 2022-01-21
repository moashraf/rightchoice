<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    protected $table = 'location';
    protected $primaryKey = 'id';

    protected $fillable = [
        'governrate',
        'district',
        'area',
    ];

    public function aqars(){
        return $this->hasMany(aqar::Class);
    }
}
