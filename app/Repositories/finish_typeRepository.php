<?php

namespace App\Repositories;

use App\Models\finish_type;
use App\Repositories\BaseRepository;

/**
 * Class finish_typeRepository
 * @package App\Repositories
 * @version July 4, 2021, 1:31 pm UTC
*/

class finish_typeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'finish_type'
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
        return finish_type::class;
    }
}
