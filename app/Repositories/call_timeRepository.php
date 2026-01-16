<?php

namespace App\Repositories;

use App\Models\call_time;
use App\Repositories\BaseRepository;

/**
 * Class call_timeRepository
 * @package App\Repositories
 * @version July 4, 2021, 11:38 am UTC
*/

class call_timeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'call_time'
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
        return call_time::class;
    }
}
