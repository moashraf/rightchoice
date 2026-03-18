<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ErrorLog extends Model
{
    protected $table = 'error_logs';

    protected $fillable = [
        'type',
        'message',
        'file',
        'line',
        'trace',
        'url',
        'count',
        'first_occurred_at',
        'last_occurred_at',
    ];

    protected $casts = [
        'first_occurred_at' => 'datetime',
        'last_occurred_at'  => 'datetime',
    ];
}
