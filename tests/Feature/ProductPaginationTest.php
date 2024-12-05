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
        // Call the API
        $response = $this->getJson(route('products.index', ['page' => 1, 'per_page' => Constants::PER_PAGE_DEFAULT]));

        // Dump the response if needed for debugging
        // dd($response->json());

        // Assert the response status
        $response->assertStatus(200);

        // Assert the structure and pagination metadata
        $response->assertJson(function (AssertableJson $json) {
            $json->where('status_code', 200)
                 ->where('success', true)
                 ->where('message', 'Products retrieved successfully.')
                 ->has('data.data') // Ensure the nested `data` key exists
                 ->has('data.meta', function (AssertableJson $meta) {
                     $meta->where('current_page', 1)
                          ->where('per_page', Constants::PER_PAGE_DEFAULT)
                          ->has('total')
                          ->has('last_page')
                          ->has('first_page_url')
                          ->has('last_page_url')
                          ->etc(); // Ensure other pagination fields exist
                 });
        });
    }
}
