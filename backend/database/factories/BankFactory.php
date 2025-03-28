<?php

namespace Database\Factories;

use App\Models\BankType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


class BankFactory extends Factory
{

    public function definition(): array
    {
        return [
            'bank_type_id' => BankType::factory(),
            'user_id' => User::factory()->state(['role' => 'bank']),
            'bank_name' => fake()->company(). ' Bank',
            'bank_address' => $this->faker->address,
            'bank_contact_number' => $this->faker->phoneNumber,
        ];
    }
}
