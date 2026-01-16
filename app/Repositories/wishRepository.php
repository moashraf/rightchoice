<?php

namespace App\Repositories;

use App\Models\wish;
use App\Repositories\BaseRepository;

/**
 * Class wishRepository
 * @package App\Repositories
 * @version July 15, 2021, 2:23 pm UTC
*/

class wishRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'aqars_id'
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
        return wish::class;
    }
}
