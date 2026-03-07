<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountDeleteRequest extends Model
{
    protected $table = 'account_delete_requests';

    protected $fillable = [
        'user_id',
        'reason',
        'status',
        'admin_note',
    ];

    /**
     * Get the user that made the request.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get status label in Arabic
     */
    public function getStatusLabelAttribute()
    {
        switch ($this->status) {
            case 'pending':
                return 'قيد الانتظار';
            case 'approved':
                return 'موافق عليه';
            case 'rejected':
                return 'مرفوض';
            default:
                return 'غير معروف';
        }
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeAttribute()
    {
        switch ($this->status) {
            case 'pending':
                return 'warning';
            case 'approved':
                return 'success';
            case 'rejected':
                return 'danger';
            default:
                return 'secondary';
        }
    }
}
