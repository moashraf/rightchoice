<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $table = 'company';
    protected $primaryKey = 'id';

    protected $fillable = [
        'Name',
        'Company_activity',
        'Employee_Name',
        'Job_title',
        'description',
        'Phone',
        'phone2',
        'landline',
        'governrate_id',
        'Building_number',
        'Floor',
        'unit_number',
        'details',
        'Tax_card',
        'Commercial_Register',
        'Password',
        'area_id',
        'district_id',
        'photo',
        'Serv_id',
        'status',
        'slug',
        'name_en',
        'slug_en',
        'Employee_Name_en',
        'Job_title_en',
        'details_en'
    ];
      public function serv(){
       
       
             return $this->belongsTo(Service::class, 'Serv_id');

       //return $this->belongsTo(Service::class, 'Company_activity');
    }

    public function employments()
    {
        return $this->belongsToMany(Employment::class);
    }
 		
 

    public function governrateq(){
        return $this->belongsTo(Governrate::class, 'governrate_id');
    }

    public function district_ashraf(){
        return $this->belongsTo(District::class, 'district_id');
    }


    public function subArea(){
        return $this->belongsTo(SubArea::class, 'area_id');
    }
    public function jobTitles(){
        return $this->belongsTo(JobTitles::class, 'job_title');
    }
    
    

}
