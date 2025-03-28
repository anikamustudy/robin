<?php

namespace Database\Factories;

use App\Models\Bank;
use Illuminate\Database\Eloquent\Factories\Factory;

class BranchFactory extends Factory
{

    public function definition(): array
    {
        return [
            'bank_id' => Bank::factory(),
            'branch_code' => $this->faker->unique()->numerify('BR#####'),
            'branch_name' => $this->faker->city . ' Branch',
            'branch_address' => $this->faker->address,
            'branch_contact_number' => $this->faker->phoneNumber,
        ];
    }
}
