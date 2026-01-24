<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallTimes extends Model
{
    use HasFactory;

    protected $table = 'call_time';
    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'call_time',
        'call_time_en'
    ];

    public function aqars(){
        return $this->hasMany(Aqar::class);
    }
}
