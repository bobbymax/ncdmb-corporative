<?php

namespace Database\Factories;

use App\Models\Expenditure;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ExpenditureFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Expenditure::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'budget_id' => '1',
            'category_id' => '1',
            'code' => $this->faker->word,
            'title' => $this->faker->word,
            'label' => Str::random(32),
            'amount' => $this->faker->numerify('######'),
            'status' => 'exhausted',
            'description' => $this->faker->sentence,
            'closed' => $this->faker->boolean,
        ];
    }
}
