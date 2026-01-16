<?php

namespace App\Repositories;

use App\Models\UserContactAqar;
use App\Repositories\BaseRepository;

/**
 * Class UserContactAqarRepository
 * @package App\Repositories
 * @version July 15, 2021, 1:40 pm UTC
*/

class UserContactAqarRepository extends BaseRepository
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
        return UserContactAqar::class;
    }
}
