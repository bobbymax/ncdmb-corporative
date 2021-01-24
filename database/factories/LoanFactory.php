<?php

namespace Database\Factories;

use App\Models\Loan;
use Illuminate\Database\Eloquent\Factories\Factory;

class LoanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Loan::class;

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
            'code' => $this->faker->word,
            'amount' => $this->faker->numerify('######'),
            'reason' => $this->faker->text,
            'description' => $this->faker->text,
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'frequency' => $this->faker->randomElement(['undefined', 'monthly', 'annually']),
            'status' => $this->faker->randomElement(['pending', 'registered', 'approved', 'denied', 'disbursed', 'closed']),
            'closed' => $this->faker->boolean,
        ];
    }
}
