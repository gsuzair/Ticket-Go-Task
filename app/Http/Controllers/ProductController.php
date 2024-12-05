<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Log;
use App\Interfaces\ResponseInterface;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller implements ResponseInterface
{
    use ResponseTrait;
    public function getProducts(ProductRequest $request){
        try {
            $requestData = $request->all();
            $products = Product::getProductsWithPagination($requestData);
            return $this->successResponse($products, 'Products retrieved successfully.');
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return $this->errorResponse('An unexpected error occurred. Please try again later.', 500);
        }
    }
}
