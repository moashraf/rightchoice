<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class offer_type
 * @package App\Models
 * @version July 4, 2021, 10:23 am UTC
 *
 * @property string $type_offer
 */
class offer_type extends Model
{


    public $table = 'offer_type';
    



    public $fillable = [
        'type_offer'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'type_offer' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    // public static $rules = [
        
    // ];

    public function errorMessages()
    {
        return
            [

            ];
    }

    
}
