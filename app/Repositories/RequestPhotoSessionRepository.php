<?php

namespace App\Repositories;

use App\Models\RequestPhotoSession;
use App\Repositories\BaseRepository;

/**
 * Class RequestPhotoSessionRepository
 * @package App\Repositories
 * @version July 15, 2021, 12:17 pm UTC
*/

class RequestPhotoSessionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'phone',
        'email',
        'user_name',
        'address',
        'description'
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
        return RequestPhotoSession::class;
    }
}
