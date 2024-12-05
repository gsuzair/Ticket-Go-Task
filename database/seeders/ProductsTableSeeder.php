<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Vendor;
use App\Utils\Constants;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        for($i = 0; $i < Constants::FAKER_PRODUCT_NAME_LENGTH; $i++){
            $fakerProductFirstName[] = addslashes($faker->word);
        }
        for($i = 0; $i < Constants::FAKER_PRODUCT_NAME_LENGTH; $i++){
            $fakerProductSecondName[] = addslashes($faker->word);
        }

        Vendor::chunk(1000, function ($vendors) use ($fakerProductFirstName, $fakerProductSecondName){
            foreach ($vendors as $vendor) {
                $numProducts = rand( Constants::NUM_OF_PRODUCTS_START,  Constants::NUM_OF_PRODUCTS_END);
                for ($j = 0; $j < $numProducts; $j++) {
                    $productName = $fakerProductFirstName[rand(Constants::START_LENGTH, Constants::PRODUCT_NAME_END_LENGTH)]." ".$fakerProductSecondName[rand(Constants::START_LENGTH, Constants::PRODUCT_NAME_END_LENGTH)];
                    $values[] = "({$vendor->id}, '{$productName}', NOW(), NOW())";
                }
            }
            if (!empty($values)) {
                $query = "INSERT INTO products (vendor_id, name, created_at, updated_at) VALUES " . implode(', ', $values);
                DB::statement($query);
            }
        });
    }
}
