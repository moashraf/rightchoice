<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class services
 * @package App\Models
 * @version July 5, 2021, 8:53 am UTC
 *
 * @property string $Service
 */
class services extends Model
{


    public $table = 'services';
    



    public $fillable = [
        'Service',
        'image',
    'description',
        'Service_en',
        'description_en'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'Service' => 'string',
        'image'=>'string',
     
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
