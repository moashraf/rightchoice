<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Floor extends Model
{
    use HasFactory;
    protected $table = 'floor';
    protected $primaryKey = 'id';

    protected $fillable = [
        'floor',
        'floor_en',
    ];
    public function Aqars() {
        return $this->hasMany(aqar::class);
    }
}
