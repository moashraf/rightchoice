<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{


    use HasFactory;
    protected $table = 'aqar_category';
    protected $primaryKey = 'id';

    protected $fillable = [
        'category_name'
    ];

    public function aqars(){
        return $this->hasMany(aqar::Class);
    }



    public function all_property_type_of_cat(){
        return $this->hasMany(TypeOfProp::Class, 'cat_id', 'id');
    }




}

