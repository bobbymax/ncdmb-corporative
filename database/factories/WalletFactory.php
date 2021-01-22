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
            'identifier' => Str::random(8),
            'bank_name' => 'Stanbic IBTC',
            'account_number' => rand(1111111111, 9999999999),
            'deposit' => 10000,
            'current' => 10000,
            'available' => 100000,
        ];
    }
}
