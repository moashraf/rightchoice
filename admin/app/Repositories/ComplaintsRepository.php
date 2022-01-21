<?php

namespace App\Repositories;

use App\Models\Complaints;
use App\Repositories\BaseRepository;

/**
 * Class ComplaintsRepository
 * @package App\Repositories
 * @version July 15, 2021, 2:27 pm UTC
*/

class ComplaintsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'aqar_id',
        'message'
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
        return Complaints::class;
    }
}
