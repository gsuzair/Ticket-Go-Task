<?php

namespace App\Utils;

class Constants
{
    public const status = [
        'success' => 'SUCCESS',
        'error' => 'ERROR',
        'pending' => 'PENDING',
    ];

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
