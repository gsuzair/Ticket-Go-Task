<?php

namespace App\Http\Controllers;

use OpenApi\Annotations as OA;
use Exception;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Log;
use App\Interfaces\ResponseInterface;
use App\Http\Requests\ProductRequest;

/**
 * @OA\Info(
 *     title="My API",
 *     version="1.0.0",
 *     description="API documentation for my Laravel app"
 * )
 */
class ProductController extends Controller implements ResponseInterface
{
    use ResponseTrait;

    /**
     * @OA\Get(
     *     path="/api/products",
     *     summary="Get list of products",
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=400, description="Error")
     * )
     */
    public function getProducts(ProductRequest $request){
        try {
            $requestData = $request->validated();
            $products = Product::getProductsWithPagination($requestData);
            return $this->successResponse($products, 'Products retrieved successfully.');
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return $this->errorResponse('An unexpected error occurred. Please try again later.', 500);
        }
    }
}
