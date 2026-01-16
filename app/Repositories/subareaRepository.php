<?php

namespace App\Repositories;

use App\Models\subarea;
use App\Repositories\BaseRepository;

/**
 * Class subareaRepository
 * @package App\Repositories
 * @version July 5, 2021, 8:44 am UTC
*/

class subareaRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'area'
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
        return subarea::class;
    }
}
