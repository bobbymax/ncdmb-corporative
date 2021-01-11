<?php

namespace Database\Factories;

use App\Models\Kin;
use Illuminate\Database\Eloquent\Factories\Factory;

class KinFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Kin::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => '1',
            'name' => $this->faker->name,
            'relationship' => $this->faker->randomElement(['brother', 'sister', 'father', 'mother']),
            'mobile' => $this->faker->e164PhoneNumber,
            'address' => $this->faker->address,
            'active' => $this->faker->boolean
        ];
    }
}
