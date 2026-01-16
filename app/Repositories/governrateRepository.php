<?php

namespace App\Repositories;

use App\Models\governrate;
use App\Repositories\BaseRepository;

/**
 * Class governrateRepository
 * @package App\Repositories
 * @version July 4, 2021, 12:05 pm UTC
*/

class governrateRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'governrate'
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
        return governrate::class;
    }
}
