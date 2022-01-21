<?php

namespace App\Repositories;

use App\Models\mzaya;
use App\Repositories\BaseRepository;

/**
 * Class mzayaRepository
 * @package App\Repositories
 * @version July 11, 2021, 1:04 pm UTC
*/

class mzayaRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'mzaya_type',
        'img_name'
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
        return mzaya::class;
    }
}
