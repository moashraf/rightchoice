<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    
    protected $table = 'notifications';
    protected $primaryKey = 'id';

    public $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'title_en',
        'message_en'
    ];


       

   public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

}
