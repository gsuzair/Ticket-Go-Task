<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Vendor;
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
        for($i = 0; $i < 10000; $i++){
            $fakerProductFirstName[] = addslashes($faker->word);
        }
        for($i = 0; $i < 10000; $i++){
            $fakerProductSecondName[] = addslashes($faker->word);
        }

        Vendor::chunk(1000, function ($vendors) use ($fakerProductFirstName, $fakerProductSecondName){
            foreach ($vendors as $vendor) {
                // Create 100-500 products for each vendor
                $numProducts = rand(100, 500);
                for ($j = 0; $j < $numProducts; $j++) {
                    $productName = $fakerProductFirstName[rand(0, 9999)]." ".$fakerProductSecondName[rand(0, 9999)];
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
