<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employment extends Model
{
    use HasFactory;
    protected $table = 'employment';
    protected $primaryKey = 'id';

    protected $fillable = [
        'employment_type'
    ];

    public function company(){
        return $this->hasMany(Company::Class);
    }
}
