<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Vendor;
use App\Utils\Constants;
use Illuminate\Testing\Fluent\AssertableJson;

class VendorAndNameFilterTest extends TestCase
{
    /** @test */
    public function filters_products_by_vendor_id_and_name_using_existing_data()
    {
        //given
        $vendor1 = Vendor::first(); 
        $vendor2 = Vendor::skip(1)->first(); 

        $product1 = Product::where('vendor_id', $vendor1->id)->first();
        $product2 = Product::where('vendor_id', $vendor2->id)->first();
        $product3 = Product::where('vendor_id', $vendor1->id)->skip(1)->first();
        
        //when 
        $response = $this->getJson(route('products.index', ['vendor_id' => $vendor1->id]));

        //then
        $filteredCountByVendor = Product::where('vendor_id', $vendor1->id)->count(); 

        $response->assertStatus(200);
        $response->assertJson(function (AssertableJson $json) use ($product1, $product3, $filteredCountByVendor) {
            $json->has('data') 
                ->where('data.meta.total', $filteredCountByVendor) 
                ->etc();

            if ($filteredCountByVendor > 0) {
                $json->where('data.data.0.name', $product1->name)
                    ->where('data.data.1.name', $product3->name);
            } else {
                $json->where('data', [])
                    ->where('data.meta.total', 0);
            }
        });

        $response = $this->getJson(route('products.index', ['name' => $product1->name]));
        $filteredCountByName = Product::where('name', $product1->name)->count();

        $response->assertStatus(200);
        $response->assertJson(function (AssertableJson $json) use ($product1, $filteredCountByName) {
            $json->has('data') 
                ->etc();

            if ($filteredCountByName > 0) {
                $json->where('data.data.0.name', $product1->name);
            } else {
                $json->where('data', [])
                    ->where('data.meta.total', 0);
            }
        });

        $response = $this->getJson(route('products.index', [
            'vendor_id' => $vendor1->id, 
            'name' => $product3->name
        ]));

        $filteredCountByVendorAndName = Product::where('vendor_id', $vendor1->id)
                                                ->where('name', $product3->name)
                                                ->count();

        $response->assertStatus(200);
        $response->assertJson(function (AssertableJson $json) use ($product3, $filteredCountByVendorAndName) {
            $json->has('data') 
                ->etc();

            if ($filteredCountByVendorAndName > 0) {
                $json->where('data.data.0.name', $product3->name);
            } else {
                $json->where('data', [])
                    ->where('data.meta.total', 0);
            }
        });
    }
}
