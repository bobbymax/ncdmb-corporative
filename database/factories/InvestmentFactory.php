<?php

namespace Database\Factories;

use App\Models\Investment;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvestmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Investment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => '1',
            'title' => $this->faker->word,
            'label' => $this->faker->word,
            'description' => $this->faker->sentence,
            'date_acquired' => $this->faker->date(),
            'expiry_date' => $this->faker->date(),
            'amount' => $this->faker->numerify('######'),
            'allocations' => $this->faker->numerify('######'),
            'closed' => $this->faker->boolean
        ];
    }
}
