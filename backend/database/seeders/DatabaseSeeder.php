<?php

namespace Database\Seeders;

use App\Models\Bank;
use App\Models\BankType;
use App\Models\Branch;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        // Seed bank types
        BankType::factory()->create([
            'name' => 'Commercial Bank',
            'slug' => 'commercial-bank'
        ]);
        BankType::factory()->create([
            'name' => 'Government Bank',
            'slug' => 'government-bank'
        ]);
        BankType::factory()->create([
            'name' => 'Development Bank',
            'slug' => 'development-bank'
        ]);

        // Seed users
        User::factory(10)->create();

        // Seed banks with associated users
        Bank::factory(3)->create();

        // Seed branches
        Branch::factory(10)->create();
    }
}
