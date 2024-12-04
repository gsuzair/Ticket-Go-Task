<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Vendor;
use Faker\Factory as Faker;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Vendor::chunk(1000, function ($vendors) {
            $faker = Faker::create();
            foreach ($vendors as $vendor) {
                $numProducts = rand(100, 500);
                for ($j = 0; $j < $numProducts; $j++) {
                    Product::create([
                        'vendor_id' => $vendor->id,
                        'name' => $faker->name,
                    ]);
                }
            }
        });
    }
}
