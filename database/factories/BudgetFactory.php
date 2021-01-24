<?php

namespace Database\Factories;

use App\Models\Budget;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BudgetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Budget::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word,
            'label' => $this->faker->unique()->word,
            'code' => Str::random(19),
            'description' => $this->faker->sentence(4),
            'amount' => $this->faker->numerify('######'),
            'start' => $this->faker->date(),
            'end' => $this->faker->date(),
            'period' => $this->faker->numberBetween(1, 12),
            'status' => $this->faker->randomElement(['pending', 'approved', 'running', 'closed']),
            'active' => $this->faker->boolean
        ];
    }
}
