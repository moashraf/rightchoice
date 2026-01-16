<?php

namespace App\Repositories;

use App\Models\Viewer;
use App\Repositories\BaseRepository;

/**
 * Class aqarRepository
 * @package App\Repositories
 * @version July 13, 2021, 11:12 am UTC
*/

class aqarRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'aqar_id',
        'points',

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
        return Viewer::class;
    }
}
