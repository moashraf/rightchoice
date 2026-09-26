<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactForm extends Model
{
    use HasFactory;

    protected $table = 'contact_form';
    protected $primaryKey = 'id';

    public static $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|regex:/^01[0-9]{9}$/',
        'subject' => 'required|string|max:255',
        'body' => 'nullable|string',
    ];

    protected $fillable = [
        'name',
        'body',
        'email',
        'phone',
        'subject',
        'user_id',
        ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
