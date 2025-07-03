<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Vendor;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::factory()->count(10)->create();
        // User::factory()->create([
        //     'email' => 'testEmail@email.com',
        //     'password' => Hash::make('testPassword')
        // ]);
        User::factory(2)
        ->create([
            'role' => 'Admin',
            'password' => Hash::make('password123')
        ]);
    }
}
