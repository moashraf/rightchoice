<?php

namespace App\Repositories;

use App\Models\Company;
use App\Repositories\BaseRepository;

/**
 * Class CompanyRepository
 * @package App\Repositories
 * @version July 15, 2021, 10:45 am UTC
*/

class CompanyRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'slug',
        'area_id',
        'district_id',
        'governrate_id',
        'serv_id',
        'employee_name',
        'job_title',
        'phone',
        'building_number',
        'floor',
        'unit_number',
        'details',
        'tax_card',
        'commercial_register',
        'photo',
        'company_activity',
        'status',
        'user_id'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Company::class;
    }
}
