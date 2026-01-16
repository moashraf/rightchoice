<?php

namespace App\Repositories;

use App\Models\floor;
use App\Repositories\BaseRepository;

/**
 * Class floorRepository
 * @package App\Repositories
 * @version July 4, 2021, 1:51 pm UTC
*/

class floorRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'floor'
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
        return floor::class;
    }
}
