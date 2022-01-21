<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferTypes extends Model
{
    use HasFactory;
    protected $table = 'offer_type';
    protected $primaryKey = 'id';

    protected $fillable = [
        'type_offer',
        'slug',
        'type_offer_en'
    ];

    public function aqars(){
        return $this->hasMany(aqar::Class);
    }
    
}
