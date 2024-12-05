<?php

namespace App\Utils;

class Constants
{
    public const PER_PAGE_DEFAULT = 15;
    public const START_LENGTH = 0;
    public const VENDORS_LENGTH = 1000;
    public const FAKER_PRODUCT_NAME_LENGTH = 10000;
    public const PRODUCT_NAME_END_LENGTH = 9999;
    public const NUM_OF_PRODUCTS_START = 100;
    public const NUM_OF_PRODUCTS_END = 500;
    public const FAKER_RATING_NAME_LENGTH = 1000;
    public const FAKER_RATING_DESC_LENGTH = 2000;
    public const NUM_OF_RATINGS_START = 1;
    public const NUM_OF_RATINGS_END = 50;
    public const RATINGS_NAME_END_LENGTH = 999;
    public const RATINGS_DESC_END_LENGTH = 1999;
    public const RATINGS_DESC_TEXT_WORDS = 12;
    public const RATING_LOW = 1;
    public const RATING_HIGH = 5;

    public const statusCodes = [
        'success' => 200,
        'error' => 400,
        'internal_server_error' => 500,
    ];

    public const apiMessages = [
        'products' => [
            'success' => 'Products retrieved successfully.',
            'no_products_found' => 'No Products found.',
        ],
        'success' => 'Request Successful.',
        'error' => 'Request failed.',
        'internal_server_error' => 'An unexpected error occurred. Please try again later.',
    ];
}
