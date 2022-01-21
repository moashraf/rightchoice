<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class Company
 * @package App\Models
 * @version July 15, 2021, 10:45 am UTC
 *
 * @property string $Name
 * @property string $slug
 * @property integer $area_id
 * @property integer $district_id
 * @property integer $governrate_id
 * @property integer $Serv_id
 * @property string $description
 * @property string $Employee_Name
 * @property string $Job_title
 * @property string $Phone
 * @property integer $building_number
 * @property integer $Floor
 * @property integer $unit_number
 * @property string $details
 * @property string $Tax_card
 * @property integer $Commercial_Register
 * @property string $photo
 * @property integer $Company_activity
 * @property integer $status
 * @property integer $user_id
 */
class Company extends Model
{


    public $table = 'company';
    



    public $fillable = [
        'Name',
        'slug',
        'area_id',
        'district_id',
        'governrate_id',
        'Serv_id',
        'description',
        'Employee_Name',
        'Job_title',
        'Phone',
        'building_number',
        'Floor',
        'unit_number',
        'details',
        'Tax_card',
        'Commercial_Register',
        'photo',
        'Company_activity',
        'status',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'Name' => 'string',
        'slug' => 'string',
        'area_id' => 'integer',
        'district_id' => 'integer',
        'governrate_id' => 'integer',
        'Serv_id' => 'integer',
        'Employee_Name' => 'string',
        'Job_title' => 'string',
        'Phone' => 'string',
        'building_number' => 'integer',
        'Floor' => 'integer',
        'unit_number' => 'integer',
        'Tax_card' => 'string',
        'Commercial_Register' => 'integer',
        'photo' => 'string',
        'Company_activity' => 'integer',
        'status' => 'integer',
        'user_id' => 'integer'
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

    public function governratinfo()
    {
        return $this->belongsTo(governrate::class, 'governrate_id');
    }

    public function districtinfo()
    {
        return $this->belongsTo(district::class, 'district_id');
    }

    public function subareainfo()
    {
        return $this->belongsTo(subarea::class, 'area_id');
    }

    public function serviceinfo()
    {
        return $this->belongsTo(services::class, 'Serv_id');
    }

    
}
