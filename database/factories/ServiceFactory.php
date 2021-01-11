<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Service::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => '1',
            'category_id' => '1',
            'title' => $this->faker->word,
            'label' => $this->faker->word,
            'description' => $this->faker->sentence,
            'method' => $this->faker->randomElement(['none', 'wallet', 'salary']),
            'status' => $this->faker->randomElement(['pending','approved','completed','declined']),
        ];
    }
}
