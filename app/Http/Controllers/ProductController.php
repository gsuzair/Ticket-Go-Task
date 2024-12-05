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
use App\Services\MetaService;
use App\Services\ProductService;
use App\Services\ResponseService;
use App\Utils\Constants;

/**
 * @OA\Info(
 *     title="Ticket GO task APIs",
 *     version="1.0.0",
 *     description="API documentation for Ticket Go task"
 * )
 */
class ProductController extends Controller implements ResponseInterface
{
    use ResponseTrait;

    protected $productService;
    protected $metaService;
    protected $responseService;

    public function __construct(ProductService $productService, MetaService $metaService, ResponseService $responseService)
    {
        $this->productService = $productService;
        $this->metaService = $metaService;
        $this->responseService = $responseService;
    }

    /**
     * @OA\Get(
     *     path="/api/products",
     *     summary="Get list of products",
     *     description="Retrieves a paginated list of products with vendor and ratings details.",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="vendor_id",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="integer"),
     *         description="Filter products by vendor ID."
     *     ),
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string"),
     *         description="Filter products by name."
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="integer", default=1),
     *         description="Page number for pagination."
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="integer", default=15),
     *         description="Number of items per page."
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful retrieval of product data",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true, description="Indicates if the request was successful."),
     *             @OA\Property(property="message", type="string", example="Products retrieved successfully.", description="Status message."),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="current_page", type="integer", example=1, description="Current page number."),
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     description="List of products.",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=1, description="Unique product identifier."),
     *                         @OA\Property(property="name", type="string", example="ea odit", description="Name of the product."),
     *                         @OA\Property(property="vendor_id", type="integer", example=1, description="ID of the vendor."),
     *                         @OA\Property(
     *                             property="vendor",
     *                             type="object",
     *                             @OA\Property(property="id", type="integer", example=1, description="Vendor ID."),
     *                             @OA\Property(property="name", type="string", example="Kris-Zemlak", description="Vendor name.")
     *                         ),
     *                         @OA\Property(
     *                             property="ratings",
     *                             type="array",
     *                             description="List of ratings for the product.",
     *                             @OA\Items(
     *                                 type="object",
     *                                 @OA\Property(property="product_id", type="integer", example=1, description="ID of the product."),
     *                                 @OA\Property(property="name", type="string", example="Erin Hansen", description="Name of the reviewer."),
     *                                 @OA\Property(property="rating", type="integer", example=5, description="Rating given by the reviewer."),
     *                                 @OA\Property(property="text", type="string", example="Expedita.", description="Review text.")
     *                             )
     *                         )
     *                     )
     *                 ),
     *                 @OA\Property(
     *                     property="meta",
     *                     type="object",
     *                     @OA\Property(property="first_page_url", type="string", example="http://ticket-go-task.test/api/products?page=1", description="URL of the first page."),
     *                     @OA\Property(property="last_page", type="integer", example=262, description="Last page number."),
     *                     @OA\Property(property="last_page_url", type="string", example="http://ticket-go-task.test/api/products?page=262", description="URL of the last page."),
     *                     @OA\Property(property="next_page_url", type="string", example="http://ticket-go-task.test/api/products?page=2", description="URL of the next page."),
     *                     @OA\Property(property="prev_page_url", type="string", nullable=true, example=null, description="URL of the previous page."),
     *                     @OA\Property(property="path", type="string", example="http://ticket-go-task.test/api/products", description="Base URL of the resource."),
     *                     @OA\Property(property="per_page", type="integer", example=1, description="Number of items per page."),
     *                     @OA\Property(property="total", type="integer", example=262, description="Total number of items available."),
     *                     @OA\Property(
     *                         property="links",
     *                         type="array",
     *                         description="Pagination links.",
     *                         @OA\Items(
     *                             type="object",
     *                             @OA\Property(property="url", type="string", nullable=true, example="http://ticket-go-task.test/api/products?page=1", description="URL for the link."),
     *                             @OA\Property(property="label", type="string", example="1", description="Label for the link."),
     *                             @OA\Property(property="active", type="boolean", example=true, description="Indicates if the link is active.")
     *                         )
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error response",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false, description="Indicates if the request failed."),
     *             @OA\Property(property="message", type="string", example="Bad request.", description="Error message.")
     *         )
     *     )
     * )
     */

    public function getProducts(ProductRequest $request){
        try {
            $requestData = $request->validated();
            $products = $this->productService->getPaginatedProducts($requestData);

            if ($products->isEmpty()) {
                return $this->successResponse([], Constants::apiMessages['products']['no_products_found']);
            }

            $meta = $this->metaService->buildMeta($products);
            $response = $this->responseService->formatResponse($products->items(), $meta);

            return $this->successResponse($response, Constants::apiMessages['products']['success']);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->errorResponse(
                Constants::apiMessages['internal_server_error'],
                Constants::statusCodes['internal_server_error']
            );
        }
    }
}
