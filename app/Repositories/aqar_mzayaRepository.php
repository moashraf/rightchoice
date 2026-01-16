<?php

namespace App\Repositories;

use App\Models\aqar_mzaya;
use App\Repositories\BaseRepository;

/**
 * Class aqar_mzayaRepository
 * @package App\Repositories
 * @version July 15, 2021, 9:47 am UTC
*/

class aqar_mzayaRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'mzaya_id',
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
        return aqar_mzaya::class;
    }
}
