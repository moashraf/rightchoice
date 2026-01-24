<?php

namespace Database\Factories;

use App\aqar;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


class AqarFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Aqar::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'slug' => $faker->sentence,
            'title' => $faker->sentence,
            'description' => $faker->paragraph,
            'excerpt' => $faker->sentence,
        ];
    }
}
