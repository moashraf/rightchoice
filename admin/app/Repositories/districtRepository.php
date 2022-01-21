<?php

namespace App\Repositories;

use App\Models\district;
use App\Repositories\BaseRepository;

/**
 * Class districtRepository
 * @package App\Repositories
 * @version July 4, 2021, 12:23 pm UTC
*/

class districtRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'district'
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
        return district::class;
    }
}
