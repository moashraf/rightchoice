<?php

namespace App\Models;

use Eloquent as Model;
use Spatie\Activitylog\Traits\LogsActivity;


/**
 * Class Complaints
 * @package App\Models
 * @version July 15, 2021, 2:27 pm UTC
 *
 * @property integer $user_id
 * @property integer $aqar_id
 * @property string $message
 */
class Complaints extends Model
{


    const COMPLAINT_PENDING = 1;
    const COMPLAINT_INPROGRESS = 2;
    const COMPLAINT_SOLVED = 3;

    public $table = 'complaints';




    public $fillable = [
        'user_id',
        'aqars_id',
        'status',
        'message'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'aqars_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    public function userinfo()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function aqarinfo()
    {
        return $this->belongsTo(aqar::class, 'aqars_id');
    }

    public function logActivities()
    {
        return $this->morphMany(LogActivity::class, 'loggable');
    }
}
