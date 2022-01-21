<?php

namespace App\Repositories;

use App\Models\Images;
use App\Repositories\BaseRepository;

/**
 * Class ImagesRepository
 * @package App\Repositories
 * @version July 13, 2021, 1:08 pm UTC
*/

class ImagesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'img_url',
        'main_img',
        'aqar_id'
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
        return Images::class;
    }
}
