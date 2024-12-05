<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Rating;
use App\Utils\Constants;
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
        for($i = 0; $i < Constants::FAKER_RATING_NAME_LENGTH; $i++){
            $fakerFirstName[] = addslashes($faker->firstName);
        }

        for($i = 0; $i < Constants::FAKER_RATING_NAME_LENGTH; $i++){
            $fakerLastName[] = addslashes($faker->lastName);
        }

        for($i = 0; $i < Constants::FAKER_RATING_DESC_LENGTH; $i++){
            $fakerDescriptions[] = addslashes($faker->text(Constants::RATINGS_DESC_TEXT_WORDS));
        }

        Product::chunk(800, function ($products) use ($fakerFirstName, $fakerLastName, $fakerDescriptions){
            foreach ($products as $product) {
                $numRatings = rand(Constants::NUM_OF_RATINGS_START, Constants::NUM_OF_RATINGS_END);
                for ($k = 0; $k < $numRatings; $k++) {
                    $name = $fakerFirstName[rand(Constants::START_LENGTH, Constants::RATINGS_NAME_END_LENGTH)]." ".$fakerLastName[rand(Constants::START_LENGTH, Constants::RATINGS_NAME_END_LENGTH)];
                    $desc = $fakerDescriptions[rand(Constants::START_LENGTH, Constants::RATINGS_DESC_END_LENGTH)];
                    $values[] = "({$product->id}, " . rand(Constants::RATING_LOW, Constants::RATING_HIGH) . ", '{$name}', '{$desc}', NOW(), NOW())";
                }
            }
        
            if (!empty($values)) {
                $query = "INSERT INTO ratings (product_id, rating, name, text, created_at, updated_at) VALUES " . implode(', ', $values);
                DB::statement($query);
            }
        });
    }
}
