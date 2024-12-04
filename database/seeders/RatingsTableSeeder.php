<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Rating;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RatingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        for($i = 0; $i < 1000; $i++){
            $fakerFirstName[] = addslashes($faker->firstName);
        }

        for($i = 0; $i < 1000; $i++){
            $fakerLastName[] = addslashes($faker->lastName);
        }

        for($i = 0; $i < 2000; $i++){
            $fakerDescriptions[] = addslashes($faker->text(12));
        }

        Product::chunk(800, function ($products, $chunkIndex) use ($fakerFirstName, $fakerLastName, $fakerDescriptions){
            foreach ($products as $product) {
                $numRatings = rand(1, 50);
                for ($k = 0; $k < $numRatings; $k++) {
                    $name = $fakerFirstName[rand(0, 999)]." ".$fakerLastName[rand(0, 999)];
                    $desc = $fakerDescriptions[rand(0, 1999)];
                    $values[] = "({$product->id}, " . rand(1, 5) . ", '{$name}', '{$desc}', NOW(), NOW())";
                }
            }
        
            if (!empty($values)) {
                $query = "INSERT INTO ratings (product_id, rating, name, text, created_at, updated_at) VALUES " . implode(', ', $values);
                DB::statement($query);
            }
        });
    }
}
