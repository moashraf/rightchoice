<?php

namespace App\Models;

use App\Enums\StatusEnum;
use App\Enums\VIPEnum;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;



/**
 * Class aqar
 * @package App\Models
 * @version July 13, 2021, 11:12 am UTC
 *
 * @property integer $status
 * @property string $slug
 * @property string $title
 * @property string $description
 * @property integer $vip
 * @property integer $finannce_bank
 * @property integer $licensed
 * @property integer $trade
 * @property integer $number_of_floors
 * @property number $total_area
 * @property integer $rooms
 * @property integer $baths
 * @property integer $floor
 * @property number $ground_area
 * @property number $land_area
 * @property number $downpayment
 * @property integer $installment_time
 * @property number $installment_value
 * @property number $monthly_rent
 * @property integer $rent_long_time
 * @property integer $offer_type
 * @property integer $property_type
 * @property integer $license_type
 * @property number $mtr_price
 * @property integer $reciving
 * @property string $rec_time
 * @property integer $user_id
 * @property integer $category
 * @property string $location
 * @property integer $call_id
 * @property integer $endorsement
 * @property number $total_price
 * @property integer $finishtype
 * @property integer $governrate_id
 * @property integer $district_id
 * @property integer $area_id
 * @property integer $compound
 * @property integer $points_avail
 * @property integer $views
 */
class aqar extends Model
{
    use SoftDeletes;


    public $table = 'aqar';




    public $fillable = [
        'status',
        'slug',
        'title',
        'description',
        'vip',
        'finannce_bank',
        'licensed',
        'trade',
        'number_of_floors',
        'total_area',
        'rooms',
        'baths',
        'floor',
        'ground_area',
        'land_area',
        'downpayment',
        'installment_time',
        'installment_value',
        'monthly_rent',
        'rent_long_time',
        'offer_type',
        'property_type',
        'license_type',
        'mtr_price',
        'reciving',
        'rec_time',
        'user_id',
        'category',
        'location',
        'call_id',
        'endorsement',
        'total_price',
        'finishtype',
        'governrate_id',
        'district_id',
        'area_id',
        'compound',
        'points_avail',
        'views',
        'title_en',
        'description_en',
        'slug_en',
        'slug'
    ];


    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'slug' => 'string',
        'title' => 'string',
        'finannce_bank' => 'integer',
        'licensed' => 'integer',
        'trade' => 'integer',
        'number_of_floors' => 'integer',
        'total_area' => 'double',
        'rooms' => 'integer',
        'baths' => 'integer',
        'floor' => 'integer',
        'downpayment' => 'double',
        'installment_time' => 'integer',
        'installment_value' => 'double',
        'monthly_rent' => 'double',
        'rent_long_time' => 'integer',
        'offer_type' => 'integer',
        'property_type' => 'integer',
        'license_type' => 'integer',
        'mtr_price' => 'double',
        'reciving' => 'integer',
        'rec_time' => 'string',
        'user_id' => 'integer',
        'category' => 'integer',
        'call_id' => 'integer',
        'endorsement' => 'integer',
        'total_price' => 'double',
        'finishtype' => 'integer',
        'governrate_id' => 'integer',
        'district_id' => 'integer',
        'area_id' => 'integer',
        'compound' => 'integer',
        'points_avail' => 'integer',
        'views' => 'integer',
        'title_en'=>'string',
        'description_en'=>'string',
        'slug_en'=>'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];



    public function getStatus()
    {
        if($this->status == 0)
            return StatusEnum::WAITACTIVE;
        else if($this->status == 1)
            return StatusEnum::ACTIVE;
        else if($this->status == 2)
            return StatusEnum::UNACTIVE;
    }

    public function getVIP()
    {
        if($this->vip == 0)
            return VIPEnum::NOTVIP;
        else if($this->vip == 1)
            return VIPEnum::VIP;
    }



    public function Images()
    {
        return $this->hasMany(Images::class)->orderBy('main_img','desc');
    }

    public function category()
    {
        return $this->belongsTo(aqar_category::class, 'category');
    }

    public function property()
    {
        return $this->belongsTo(property_type::class, 'property_type');
    }

    public function offertype()
    {
        return $this->belongsTo(offer_type::class, 'offer_type');
    }
      public function mzaya()
    {
        return $this->belongsToMany(mzaya::Class, 'aqar_mzaya',
          'aqar_id', 'mzaya_id');
    }

    public function mzayaAqar()
    {
        return $this->hasMany(MzayaAqar::Class);
    }


    public function user(){
        return $this->belongsTo(User::class);
    }




    public function location(){
        return $this->belongsTo(Location::class);
    }







    public function callTimes(){
        return $this->belongsTo(call_time::class, 'call_id');
   }
    public function license_type(){
        return $this->belongsTo(license_type::class);
    }
    public function finishType(){
        return $this->belongsTo(finish_type::class, 'finishtype');
    }


    public function governrateq(){
        return $this->belongsTo(governrate::class, 'governrate_id');
    }


    public function districte(){
        return $this->belongsTo(district::class, 'district_id');
    }


    public function subAreaa(){
        return $this->belongsTo(subarea::class, 'area_id');
    }


    public function compounds(){
        return $this->belongsTo(Compound::class, 'compound');
    }

    public function propertyType() {
        return $this->belongsTo(property_type::class, 'property_type');
    }




    public function logActivities()
    {
        return $this->morphMany(LogActivity::class, 'loggable');
    }

    public function users_views()
    {
        return $this->belongsToMany(User::class,'usercontactaqar','aqars_id','user_id');
    }


    public function aqar()
    {
        return $this->belongsToMany(User::class,'usercontactaqar','aqars_id','user_id');
    }





}
