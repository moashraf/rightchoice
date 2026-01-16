<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class ContactForm
 * @package App\Models
 * @version July 15, 2021, 2:30 pm UTC
 *
 * @property string $phone
 * @property string $email
 * @property string $subject
 * @property string $body
 */
class ContactForm extends Model
{


    public $table = 'contact_form';




    public $fillable = [
        'phone',
        'email',
        'subject',
        'body'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'phone' => 'string',
        'email' => 'string',
        'subject' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];


}
