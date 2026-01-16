<?php

namespace App\Repositories;

use App\Models\blog;
use App\Repositories\BaseRepository;

/**
 * Class blogRepository
 * @package App\Repositories
 * @version July 1, 2021, 1:11 pm UTC
*/

class blogRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'seo_title',
        'status',
        'main_img_alt',
        'single_photo',
        'sort_num',
        'meta_description',
        'number_of_visits',
        'title',
        'description',
        'slug',
        'canonical',
        'created_at',
        'updated_at'
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
        return blog::class;
    }
}
