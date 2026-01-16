<?php

namespace App\Repositories;

use App\Models\ContactForm;
use App\Repositories\BaseRepository;

/**
 * Class ContactFormRepository
 * @package App\Repositories
 * @version July 15, 2021, 2:30 pm UTC
*/

class ContactFormRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'phone',
        'email',
        'subject',
        'body'
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
        return ContactForm::class;
    }
}
