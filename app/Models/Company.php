<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
        'Phone',
        'phone2',
        'landline',
        'governrate_id',
        'building_number',
        'Floor',
        'unit_number',
        'details',
        'Tax_card',
        'Commercial_Register',
        'area_id',
        'district_id',
        'photo',
        'Serv_id',
        'status',
        'slug',
        'user_id',
        'name_en',
        'slug_en',
        'Employee_Name_en',
        'Job_title_en',
        'details_en'
    ];

    /**
     * Validation rules for creating/updating a Company.
     */
    public static $rules = [
        'Name'                => 'required|string|max:255',
        'slug'                => 'nullable|string',
        'user_id'             => 'nullable|integer',
        'governrate_id'       => 'required|integer',
        'district_id'         => 'required|integer',
        'area_id'             => 'nullable|integer',
        'Serv_id'             => 'required|integer',
        'Employee_Name'       => 'nullable|string|max:255',
        'Job_title'           => 'nullable|string|max:255',
        'Phone'               => 'nullable|string|max:255',
        'phone2'              => 'nullable|string|max:255',
        'landline'            => 'nullable|string|max:255',
        'building_number'     => 'nullable|string|max:255',
        'Floor'               => 'nullable|string|max:10',
        'unit_number'         => 'nullable|string|max:255',
        'details'             => 'nullable|string',
        'Tax_card'            => 'nullable|string|max:255',
        'Commercial_Register' => 'nullable|string|max:255',
        'photo'               => 'nullable|string|max:255',
        'Company_activity'    => 'nullable|integer',
        'status'              => 'nullable|integer',
        'name_en'             => 'nullable|string|max:255',
        'slug_en'             => 'nullable|string|max:255',
        'Employee_Name_en'    => 'nullable|string|max:255',
        'Job_title_en'        => 'nullable|string|max:255',
        'details_en'          => 'nullable|string|max:255',
    ];

    /**
     * Auto-generate slug from Name before creating.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($company) {
            if (empty($company->slug)) {
                $company->slug = Str::slug($company->Name) ?: Str::random(10);
            }
            if (empty($company->slug_en) && !empty($company->name_en)) {
                $company->slug_en = Str::slug($company->name_en);
            }
            if (is_null($company->status)) {
                $company->status = 0;
            }
        });
    }

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



    public function subArea(){
        return $this->belongsTo(SubArea::class, 'area_id');
    }
    public function jobTitles(){
        return $this->belongsTo(JobTitles::class, 'job_title');
    }



}
