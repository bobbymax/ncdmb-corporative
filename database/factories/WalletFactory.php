<?php

namespace Database\Factories;

use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class WalletFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Wallet::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'identifier' => Str::random(8),
            'deposit' => $this->faker->numerify('######'),
            'current' => $this->faker->numerify('######'),
            'available' => $this->faker->numerify('######'),
            'ledger' => $this->faker->numerify('######'),
            'bank_name' => 'Stanbic IBTC',
            'account_number' => '0056075457'
        ];
    }
}