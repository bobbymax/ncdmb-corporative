<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MemberFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'membership_no' => Str::random(8),
            'staff_no' => Str::random(5),
            'designation' => $this->faker->randomElement(['Senior Officer', 'Junior Officer', 'DG']),
            'firstname' => $this->faker->name,
            'middlename' => $this->faker->name,
            'surname' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'mobile' => $this->faker->unique()->e164PhoneNumber,
            'type' => $this->faker->randomElement(['member', 'exco']),
            'date_joined' => $this->faker->date('Y-m-d'),
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // password
            'remember_token' => Str::random(10),
        ];
    }
}
