<?php

namespace App\Repositories;

use App\Models\LicenseType;
use App\Repositories\BaseRepository;

/**
 * Class license_typeRepository
 * @package App\Repositories
 * @version July 4, 2021, 2:10 pm UTC
*/

class license_typeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'license_type'
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
        return LicenseType::class;
    }
}
