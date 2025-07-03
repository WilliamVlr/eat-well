<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0; $i < 2; $i++) { 
            User::factory()
            ->create([
                'email' => "admin{$i}@mail.com",
                'role' => 'Admin',
                'password' => Hash::make('password123')
            ]);
        }
    }
}
