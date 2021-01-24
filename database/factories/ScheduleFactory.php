<?php

namespace Database\Factories;

use App\Models\Schedule;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScheduleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Schedule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'loan_id' => '1',
            'amount' => $this->faker->numerify('######'),
            'due_date' => $this->faker->date(),
            'status' => $this->faker->randomElement(['pending', 'paid', 'overdue']),
        ];
    }
}
