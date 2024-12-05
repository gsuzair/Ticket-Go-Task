<?php
namespace App\Services;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductService
{
    /**
     * Fetch paginated products.
     *
     * @param array $requestData
     * @return LengthAwarePaginator
     */
    public function getPaginatedProducts(array $requestData): LengthAwarePaginator
    {
        return Product::getProductsWithPagination($requestData);
    }
}
