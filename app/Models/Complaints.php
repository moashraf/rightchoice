<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Complaints extends Model
{
    use HasFactory;
    use SoftDeletes;

    const COMPLAINT_PENDING    = 1;
    const COMPLAINT_INPROGRESS = 2;
    const COMPLAINT_SOLVED     = 3;

    protected $table = 'complaints';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'aqars_id',
        'message',
        'solution_details',
        'status',
        'updated_by',
    ];

    protected static function boot()
    {
        parent::boot();

        static::updating(function ($model) {
            $adminId = Auth::guard('admin')->id() ?? Auth::id();
            if ($adminId) {
                $model->updated_by = $adminId;
            }
        });
    }

    public static $rules = [
        'user_id'  => 'required',
        'aqars_id' => 'required',
       // 'message'  => 'required',
    ];

    public function userinfo()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function aqarinfo()
    {
        return $this->belongsTo(\App\Models\aqar::class, 'aqars_id');
    }

    /**
     * The admin who last handled / updated this complaint.
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by')->withTrashed();
    }

    public function handlerName(): string
    {
        return $this->updatedBy?->name ?: 'لا يوجد';
    }

}
