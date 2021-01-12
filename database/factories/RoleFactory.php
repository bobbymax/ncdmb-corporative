<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Role::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->randomElement(['SUPER ADMIN', 'USER', 'EXCO']),
            'label' => $this->faker->word,
            'slots' => $this->faker->numberBetween(1, 10),
            'deactivated' => $this->faker->boolean,
        ];
    }
}