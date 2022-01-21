<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class Images
 * @package App\Models
 * @version July 13, 2021, 1:08 pm UTC
 *
 * @property string $img_url
 * @property boolean $main_img
 * @property integer $aqar_id
 */
class Images extends Model
{


    public $table = 'aqars_imgs';
    



    public $fillable = [
        'img_url',
        'main_img',
        'aqar_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'img_url' => 'string',
        'main_img' => 'boolean',
        'aqar_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function aqar()
    {
        return $this->belongsTo(aqar::class,'aqar_id' ,'id');
    }
    
}
