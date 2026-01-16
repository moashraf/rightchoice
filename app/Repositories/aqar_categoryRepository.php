<?php

namespace App\Repositories;

use App\Models\aqar_category;
use App\Repositories\BaseRepository;

/**
 * Class aqar_categoryRepository
 * @package App\Repositories
 * @version July 4, 2021, 11:24 am UTC
*/

class aqar_categoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'category_name'
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
        return aqar_category::class;
    }
}
