<?php

namespace Database\Factories;

use App\Models\Investment;
use App\Models\Specification;
use Illuminate\Database\Eloquent\Factories\Factory;

class SpecificationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Specification::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'investment_id' => Investment::factory(),
            'title' => $this->faker->word,
            'label' => $this->faker->word,
            'description' => $this->faker->sentence,
            'amount' => $this->faker->numerify('######'),
            'slots' => $this->faker->numerify('######'),
            'status' => $this->faker->randomElement(['pending', 'exhausted']),
        ];
    }
}
