<?php

namespace App\Repositories;

use App\Models\aqar;
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
        'status',
        'slug',
        'title',
        'description',
        'vip',
        'finannce_bank',
        'licensed',
        'trade',
        'number_of_floors',
        'total_area',
        'rooms',
        'baths',
        'floor',
        'ground_area',
        'land_area',
        'downpayment',
        'installment_time',
        'installment_value',
        'monthly_rent',
        'rent_long_time',
        'offer_type',
        'property_type',
        'license_type',
        'mtr_price',
        'reciving',
        'rec_time',
        'user_id',
        'category',
        'location',
        'call_id',
        'endorsement',
        'total_price',
        'finishtype',
        'governrate_id',
        'district_id',
        'area_id',
        'compound',
        'points_avail',
        'views'
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
        return aqar::class;
    }
}
