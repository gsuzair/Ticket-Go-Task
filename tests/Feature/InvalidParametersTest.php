<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Utils\Constants;
use Illuminate\Testing\Fluent\AssertableJson;

class InvalidParametersTest extends TestCase
{
    public function test_invalid_vendor_id()
    {
        $response = $this->getJson(route('products.index', ['vendor_id' => 'invalid_string']));

        $response->assertStatus(422)
            ->assertJson([
                'status_code' => 422,
                'success' => false,
                'message' => 'Validation errors.',
                'errors' => [
                    'vendor_id' => ['Vendor ID must be a valid integer.'],
                ],
                'data' => null,
            ]);
    }

    public function test_vendor_id_must_be_at_least_one()
    {
        $response = $this->getJson(route('products.index', ['vendor_id' => 0]));

        $response->assertStatus(422)
            ->assertJson([
                'status_code' => 422,
                'success' => false,
                'message' => 'Validation errors.',
                'errors' => [
                    'vendor_id' => ['Vendor ID must be at least 1.'],
                ],
                'data' => null,
            ]);
    }

    public function test_page_must_be_integer()
    {
        $response = $this->getJson(route('products.index', ['page' => 'invalid_string']));

        $response->assertStatus(422)
            ->assertJson([
                'status_code' => 422,
                'success' => false,
                'message' => 'Validation errors.',
                'errors' => [
                    'page' => ['Page must be a valid integer.'],
                ],
                'data' => null,
            ]);
    }

    public function test_invalid_product_name()
    {
        $value = ['invalid_array'];
        $response = $this->getJson(route('products.index', ['name' => $value]));

        $response->assertStatus(422)
            ->assertJson([
                'status_code' => 422,
                'success' => false,
                'message' => 'Validation errors.',
                'errors' => [
                    'name' => ['Name must be a valid string.'],
                ],
                'data' => null,
            ]);
    }

    public function test_invalid_per_page()
    {
        $response = $this->getJson(route('products.index', ['per_page' => -10]));

        $response->assertStatus(422)
            ->assertJson([
                'status_code' => 422,
                'success' => false,
                'message' => 'Validation errors.',
                'errors' => [
                    'per_page' => ['Per page must be at least 1.'],
                ],
                'data' => null,
            ]);
    }

    public function test_invalid_per_page2()
    {
        $response = $this->getJson(route('products.index', ['per_page' => 101]));

        $response->assertStatus(422)
            ->assertJson([
                'status_code' => 422,
                'success' => false,
                'message' => 'Validation errors.',
                'errors' => [
                    'per_page' => ['Per page may not be greater than 100.'],
                ],
                'data' => null,
            ]);
    }

    public function test_invalid_page()
    {
        $response = $this->getJson(route('products.index', ['page' => 0]));

        $response->assertStatus(422)
            ->assertJson([
                'status_code' => 422,
                'success' => false,
                'message' => 'Validation errors.',
                'errors' => [
                    'page' => ['Page must be at least 1.'],
                ],
                'data' => null,
            ]);
    }

    public function test_name_exceeding_max_length()
    {

        $longString = str_repeat('a', 256);

        $response = $this->getJson(route('products.index', ['name' => $longString]));

        $response->assertStatus(422)
            ->assertJson([
                'status_code' => 422,
                'success' => false,
                'message' => 'Validation errors.',
                'errors' => [
                    'name' => ['Name may not be greater than 255 characters.'],
                ],
                'data' => null,
            ]);
    }

    public function test_per_page_must_be_integer()
    {
        $response = $this->getJson(route('products.index', ['per_page' => 'invalid_string']));

        $response->assertStatus(422)
            ->assertJson([
                'status_code' => 422,
                'success' => false,
                'message' => 'Validation errors.',
                'errors' => [
                    'per_page' => ['Per page must be a valid integer.'],
                ],
                'data' => null,
            ]);
    }
}
