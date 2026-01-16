<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobTitles extends Model
{
    use HasFactory;
    
    protected $table = 'jobTitles';
    public $timestamps = false;
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'Job_title',
        'Job_title_en',
        
        ];
    
    
}
