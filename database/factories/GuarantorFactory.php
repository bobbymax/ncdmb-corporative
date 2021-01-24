<?php

namespace Database\Factories;

use App\Models\Guarantor;
use Illuminate\Database\Eloquent\Factories\Factory;

class GuarantorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Guarantor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'loan_id' => '1',
            'user_id' => '1',
            'remark' => $this->faker->sentence,
            'status' => $this->faker->randomElement(['pending', 'approved', 'denied'])
        ];
    }
}
