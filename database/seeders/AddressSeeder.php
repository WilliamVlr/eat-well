<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=1; $i <= 2; $i++) { 
            Address::factory()
            ->recycle(
                User::factory()
                ->create([
                    'email' => "customer{$i}@mail.com",
                    'password' => Hash::make('password'),
                    'role' => 'Customer',
                ])
            )
            ->create([
                'is_default' => true,
            ]);
        }
        
        Address::factory()
        ->recycle(
            User::factory()
            ->create([
                'email' => "customer3@mail.com",
                'password' => Hash::make('password'),
                'role' => 'Customer',
            ])
        )
        ->create([
            'is_default' => true,
            'notes' => fake()->sentence(10),
        ]);

        Address::factory(3)
        ->recycle(User::inRandomOrder()->first())
        ->create();
    }
}
