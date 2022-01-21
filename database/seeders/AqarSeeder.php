<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AqarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('aqars')->insert([
            'slug' => 'hello third slug',
            'title' => 'Title Hello',
            'description' => 'loremIpsum thats how it works',
            'excerpt' => 'helooooooooooo',
            'vip' => true,
            'finannce_bank' => false,
            'licensed' => false,
            'trade' => false,
            'number_of_floors' => 10,
            'total_area' => 150.0,
            'rooms' => 1,
            'baths' => 2,
            'floor' => 3,
            'ground_area' => 125.5,
            'land_area' => 10.0,
            'downpayment' => 100.000,
            'installment_time' => 1,
            'installment_value' => 12.5,
            'monthly_rent' => 11.1,
            'rent_long_time' => true,
            'offer_type' => 4,
            'property_type' => 22,
            'license_type' => 6,
            'mtr_price' => 6.7,
            'reciving' => true,
            'rec_time' => '2018-10-18 15:36:41',
        ]);
    }
}
