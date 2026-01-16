<?php

namespace App\Repositories;

use App\Models\compound;
use App\Repositories\BaseRepository;

/**
 * Class compoundRepository
 * @package App\Repositories
 * @version July 4, 2021, 11:45 am UTC
*/

class compoundRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'compound'
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
        return compound::class;
    }
}
