<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class archive extends Model
{
    use HasFactory;

    protected $table = 'archives2';
    protected $primaryKey = 'id';

    protected $fillable = [
        'slug',
        'title',
        'description',
        'compound',
        'vip',
        'finance_bank',
        'licensed',
        'category',
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
        'loc_id',
        'cat_id',
        'call_id',
        'finishtype',
        'total_price',
        'endorsement',
        'governrate_id',
        'area_id',
        'district_id',
        'points_avail',
        'views',
        'status',
        'title_en',
        'description_en',
        'slug_en',
        'org_aqar_id'
    ];


    //public function scopeFilter($query, array fn($query, $search))
    public static function pointCalculate($price){

        $points = number_format((float)($price/50000), 2, '.', '');

        return $points;
    }
    
    public static function pointCalculateRent($price){

        $points = number_format((float)($price/250), 2, '.', '');

        return $points;
    }


    public static function showNumber($aqarPoints, $userPoints, $priceStatus){

         if($userPoints >= $aqarPoints && $priceStatus == 1){
            $show =    true;
        }else {
            $show =  false;
        };

        return $show;
    }

    public function mzaya()
    {
        return $this->belongsToMany(Mzaya::Class, 'aqar_mzaya', 
          'aqar_id', 'mzaya_id');
    }

    public function mzayaAqar()
    {
        return $this->hasMany(MzayaAqar::Class);
    }
    
    public function floorNo()
    {
        return $this->belongsTo(Floor::class,  'floor');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function offerTypes(){
        return $this->belongsTo(OfferTypes::class, 'offer_type');
    }
    
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function location(){
        return $this->belongsTo(Location::class);
    }
    public function callTimes(){
        return $this->belongsTo(Calltime::class, 'call_id');
   }
    public function license_type(){
        return $this->belongsTo(license_type::class);
    }
    public function finishType(){
        return $this->belongsTo(Finish_type::class, 'finishtype');
    }


    public function governrateq(){
        return $this->belongsTo(Governrate::class, 'governrate_id');
    }


    public function districte(){
        return $this->belongsTo(District::class, 'district_id');
    }


    public function subAreaa(){
        return $this->belongsTo(SubArea::class, 'area_id');
    }

    
    public function compounds(){
        return $this->belongsTo(Compound::class, 'compound');
    }

    public function propertyType() {
        return $this->belongsTo(TypeOfProp::class, 'property_type');
    }
    
    
    
    
    
    public function images(){
        return $this->hasMany(Images::class);
    }
    
     public function mainImage(){
        return $this->belongsTo(Images::class,'org_aqar_id','aqar_id')->where('main_img', 1);
    }
    
    public function firstImage(){
        return $this->belongsTo(Images::class,'org_aqar_id','aqar_id')->where('main_img', 0);
    }

    public function wisheList(){
        return $this->hasMany(wish::class);
    }

    
}
