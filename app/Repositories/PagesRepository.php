<?php

namespace App\Repositories;

use App\Models\Pages;
use App\Repositories\BaseRepository;

/**
 * Class PagesRepository
 * @package App\Repositories
 * @version July 13, 2021, 9:58 am UTC
*/

class PagesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'page_name',
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
        return Pages::class;
    }
}
