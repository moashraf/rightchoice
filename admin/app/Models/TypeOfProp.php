<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeOfProp extends Model
{
    use HasFactory;
    
    
    protected $table = 'property_type';
    protected $primaryKey = 'id';

    protected $fillable = [
        'property_type'
    ];

    public function aqars(){
        return $this->hasMany(aqar::Class);
    }
    
    
}
