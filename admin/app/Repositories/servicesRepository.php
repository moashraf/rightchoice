<?php

namespace App\Repositories;

use App\Models\services;
use App\Repositories\BaseRepository;

/**
 * Class servicesRepository
 * @package App\Repositories
 * @version July 5, 2021, 8:53 am UTC
*/

class servicesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'Service',
        'image',
        'description',
        'Service_en',
        'description_en'
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
        return services::class;
    }
}
