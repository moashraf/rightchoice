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
        'Name',
        'slug',
        'area_id',
        'district_id',
        'governrate_id',
        'Serv_id',
        'name_of_real_estate_developer',
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
