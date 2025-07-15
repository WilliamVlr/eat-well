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
        $users = User::all();

        foreach ($users as $user) {
            // Buat alamat utama (is_default = true)
            Address::factory()->create([
                'userId' => $user->userId,
                'is_default' => true,
            ]);

            // Buat minimal satu alamat tambahan (is_default = false)
            Address::factory()->count(rand(1, 3))->create([ // Minimal 1, bisa sampai 3 alamat tambahan
                'userId' => $user->userId,
                'is_default' => false,
            ]);
        }
    }
}
