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
    public function test_filters_products_by_vendor_id()
    {
        // Given
        $vendor = Vendor::first();
        $product1 = Product::where('vendor_id', $vendor->id)->first();
        $product2 = Product::where('vendor_id', $vendor->id)->skip(1)->first();
        $filteredCountByVendor = Product::where('vendor_id', $vendor->id)->count();

        // When
        $response = $this->getJson(route('products.index', ['vendor_id' => $vendor->id]));

        // Then
        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) => 
            $this->assertFilteredJsonResponse($json, [$product1, $product2], $filteredCountByVendor)
        );
    }

    public function test_filters_products_by_name()
    {
        // Given
        $product = Product::first();
        $filteredCountByName = Product::where('name', 'like', '%' . strtolower($product->name) . '%')->count();

        // When
        $response = $this->getJson(route('products.index', ['name' => $product->name]));

        // Then
        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) => 
            $this->assertFilteredJsonResponse($json, [$product], $filteredCountByName)
        );
    }

    public function test_filters_products_by_vendor_id_and_name()
    {
        // Given
        $vendor = Vendor::first();
        $product = Product::where('vendor_id', $vendor->id)->skip(1)->first();
        $filteredCountByVendorAndName = Product::where('vendor_id', $vendor->id)
                                            ->where('name', 'like', '%' . strtolower($product->name) . '%')
                                            ->count();

        // When
        $response = $this->getJson(route('products.index', [
            'vendor_id' => $vendor->id,
            'name' => $product->name,
        ]));

        // Then
        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) => 
            $this->assertFilteredJsonResponse($json, [$product], $filteredCountByVendorAndName)
        );
    }

    private function assertFilteredJsonResponse(AssertableJson $json, $products, $total)
    {
        $json->where('data.meta.total', $total)
            ->etc();

        if ($total > 0) {
            foreach ($products as $index => $product) {
                $json->where("data.data.$index.name", $product->name);
            }
        } else {
            $json->where('data', [])
                ->where('data.meta.total', 0);
        }
    }



}
