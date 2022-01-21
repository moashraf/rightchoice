<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class SettingSite
 * @package App\Models
 * @version July 27, 2021, 12:11 pm UTC
 *
 * @property string $Title
 * @property string $Address
 * @property string $Mobile
 * @property string $Phone_land_line
 * @property string $mail
 * @property string $facebook
 * @property string $linkedin
 * @property string $insta
 * @property string $tiwiter
 * @property string $youtube
 * @property string $map_link
 * @property string $meta_title
 * @property string $meta_keyword
 * @property string $meta_description
 * @property string $logo
 * @property string $icon
 * @property string $short_dis_about
 * @property string $whatsapp
 * @property string $featured_ads_dis
 * @property string $estate_sale_dis
 * @property string $estate_sale_rent
 * @property string $services_dis
 * @property string $most_searched_dis
 * @property string $connect_us_dis
 */
class SettingSite extends Model
{


    public $table = 'settingsite';
    



    public $fillable = [
        'Title',
        'Address',
        'Mobile',
        'Phone_land_line',
        'mail',
        'facebook',
        'linkedin',
        'insta',
        'tiwiter',
        'youtube',
        'map_link',
        'meta_title',
        'meta_keyword',
        'meta_description',
        'logo',
        'icon',
        'short_dis_about',
        'whatsapp',
        'featured_ads_dis',
        'estate_sale_dis',
        'estate_sale_rent',
        'services_dis',
        'most_searched_dis',
        'connect_us_dis',
        'call_to_action_title_en',
        'call_to_action_title',
        'call_to_action_desc_en',
        'call_to_action_desc'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'Title' => 'string',
        'Address' => 'string',
        'Mobile' => 'string',
        'Phone_land_line' => 'string',
        'mail' => 'string',
        'facebook' => 'string',
        'linkedin' => 'string',
        'insta' => 'string',
        'tiwiter' => 'string',
        'youtube' => 'string',
        'map_link' => 'string',
        'meta_title' => 'string',
        'meta_keyword' => 'string',
        'meta_description' => 'string',
        'logo' => 'string',
        'icon' => 'string',
        'short_dis_about' => 'string',
        'whatsapp' => 'string',
        'featured_ads_dis' => 'string',
        'estate_sale_dis' => 'string',
        'estate_sale_rent' => 'string',
        'services_dis' => 'string',
        'most_searched_dis' => 'string',
        'connect_us_dis' => 'string',
         'call_to_action_title_en' => 'string',
        'call_to_action_title' => 'string',
        'call_to_action_desc_en' => 'string',
        'call_to_action_desc' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

}
