<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendors = [
            [
                'userId' => User::factory()->create(['role' => 'Vendor'])->userId,
                'addressId' => 1,
                'name' => 'Nusantara Delights',
                'breakfast_delivery' => '06:30-09:30',
                'lunch_delivery' => '11:00-14:00',
                'dinner_delivery' => '17:30-20:00',
                'logo' => 'nusantara-delights-logo.png',
                'phone_number' => '081234567890',
                'rating' => 4.7,
            ],
            [
                'userId' => 2,
                'addressId' => 2,
                'name' => 'Tropical Bites',
                'breakfast_delivery' => '07:00-10:00',
                'lunch_delivery' => '12:00-15:00',
                'dinner_delivery' => '18:00-21:00',
                'logo' => 'tropical-bites-logo.png',
                'phone_number' => '089876543210',
                'rating' => 4.3,
            ],
            [
                'userId' => 3,
                'addressId' => 3,
                'name' => 'Sari Rasa Kitchen',
                'breakfast_delivery' => '06:00-08:30',
                'lunch_delivery' => '11:30-14:30',
                'dinner_delivery' => '17:00-19:30',
                'logo' => 'sari-rasa-kitchen-logo.png',
                'phone_number' => '082112345678',
                'rating' => 4.5,
            ],
        ];

        foreach($vendors as $vendor) {
           Vendor::firstOrCreate(['name' => $vendor['name']], $vendor);
        }

        Vendor::factory()->count(100)->create();
    }
}
