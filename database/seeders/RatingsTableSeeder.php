<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Rating;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class RatingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::chunk(1000, function ($products) {
            $faker = Faker::create();
            foreach ($products as $product) {
                $numRatings = rand(1, 50);
                for ($k = 0; $k < $numRatings; $k++) {
                    Rating::create([
                        'product_id' => $product->id,
                        'rating' => rand(1, 5),
                        'name' => $faker->name,
                        'text' => $faker->text,
                    ]);
                }
            }
        });
    }
}
