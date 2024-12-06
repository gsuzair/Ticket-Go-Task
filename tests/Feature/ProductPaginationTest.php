<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Utils\Constants;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductPaginationTest extends TestCase
{
    /** @test */
    public function it_returns_correct_pagination_metadata_for_product_listings()
    {
        $response = $this->getJson(route('products.index', ['page' => 1, 'per_page' => Constants::PER_PAGE_DEFAULT]));
        $response->assertStatus(200);
        $response->assertJson(function (AssertableJson $json) {
            $json->where('status_code', 200)
                 ->where('success', true)
                 ->where('message', 'Products retrieved successfully.')
                 ->has('data.data')
                 ->has('data.meta', function (AssertableJson $meta) {
                     $meta->where('current_page', 1)
                          ->where('per_page', Constants::PER_PAGE_DEFAULT)
                          ->has('total')
                          ->has('last_page')
                          ->has('first_page_url')
                          ->has('last_page_url')
                          ->etc(); 
                 });
        });
    }

    public function test_out_of_bound_pagination()
    {
        $response = $this->getJson(route('products.index', ['page' => 1300000, 'per_page' => Constants::PER_PAGE_DEFAULT]));
        $response->assertStatus(200);
        $response->assertJson(function (AssertableJson $json) {
            $json->where('status_code', 200)
                 ->where('success', true)
                 ->where('message', 'No Products found.')
                 ->has('data');
        });
    }
}
