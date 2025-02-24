<?php

namespace Database\Seeders;

use App\Models\Vendor;
use App\Utils\Constants;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class VendorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        for ($i = 0; $i < Constants::VENDORS_LENGTH; $i++) {
            $vendors[] = [
                'name' => $faker->company,
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ];
        }

        Vendor::insert($vendors);
    }
}
