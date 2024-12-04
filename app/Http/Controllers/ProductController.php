<?php

namespace App\Http\Controllers;

use App\Interfaces\ResponseInterface;
use App\Models\Product;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller implements ResponseInterface
{
    use ResponseTrait;
    public function getProducts(Request $request){
        try {
            $products = Product::getProductsWithPagination();
            return $this->successResponse($products, 'Products retrieved successfully.');
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return $this->errorResponse('An unexpected error occurred. Please try again later.', 500);
        }
    }
}
