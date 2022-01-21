<?php

namespace App\Repositories;

use App\Models\property_type;
use App\Repositories\BaseRepository;

/**
 * Class property_typeRepository
 * @package App\Repositories
 * @version July 4, 2021, 11:09 am UTC
*/

class property_typeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'property_type'
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
        return property_type::class;
    }
}
