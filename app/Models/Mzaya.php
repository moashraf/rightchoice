<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mzaya extends Model
{
    use HasFactory;

    protected $table = 'mzaya';
    protected $primaryKey = 'id';

    protected $fillable = [
        'mzaya_type',
        'img_name',
        'mzaya_type_en',
    ];

    public function aqars()
    {
        return $this->belongsToMany(aqar::Class, 'aqar_mzaya', 
          'aqar_id', 'mzaya_id');
    }
}
