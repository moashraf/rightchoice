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
        'name',
        'company_activity',
        'employee_name',
        'job_title',
        'phone',
        'phone2',
        'landline',
        'governrate_id',
        'building_number',
        'floor',
        'unit_number',
        'details',
        'tax_card',
        'commercial_register',
        'area_id',
        'district_id',
        'photo',
        'serv_id',
        'status',
        'slug',
        'user_id',
        'name_en',
        'slug_en',
        'employee_name_en',
        'job_title_en',
        'details_en'
    ];

    /**
     * Validation rules for creating/updating a Company.
     */
    public static $rules = [
        'name'                => 'required|string|max:255',
        'slug'                => 'nullable|string',
        'user_id'             => 'nullable|integer',
        'governrate_id'       => 'required|integer',
        'district_id'         => 'required|integer',
        'area_id'             => 'nullable|integer',
        'serv_id'             => 'required|integer',
        'employee_name'       => 'nullable|string|max:255',
        'job_title'           => 'nullable|string|max:255',
        'phone'               => 'nullable|string|max:255',
        'phone2'              => 'nullable|string|max:255',
        'landline'            => 'nullable|string|max:255',
        'building_number'     => 'nullable|string|max:255',
        'floor'               => 'nullable|string|max:10',
        'unit_number'         => 'nullable|string|max:255',
        'details'             => 'nullable|string',
        'tax_card'            => 'nullable|string|max:255',
        'commercial_register' => 'nullable|string|max:255',
         'company_activity'    => 'nullable|integer',
        'status'              => 'nullable|integer',
        'name_en'             => 'nullable|string|max:255',
        'slug_en'             => 'nullable|string|max:255',
        'employee_name_en'    => 'nullable|string|max:255',
        'job_title_en'        => 'nullable|string|max:255',
        'details_en'          => 'nullable|string|max:255',
    ];

    /**
     * Auto-generate slug from name before creating.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($company) {
            if (empty($company->slug)) {
                $company->slug = Str::slug($company->name) ?: Str::random(10);
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


             return $this->belongsTo(Service::class, 'serv_id');

       //return $this->belongsTo(Service::class, 'company_activity');
    }

    public function employments()
    {
        return $this->belongsToMany(Employment::class);
    }


    public function district_data(){
        return $this->belongsTo(District::class, 'district_id');
    }

    public function governrateq(){
        return $this->belongsTo(Governrate::class, 'governrate_id');
    }

    public function subArea(){
        return $this->belongsTo(SubArea::class, 'area_id');
    }

    public function jobTitle(){
        return $this->belongsTo(JobTitles::class, 'job_title', 'id');
    }

    public function jobTitles(){
        return $this->jobTitle();
    }



}
