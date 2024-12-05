<?php

namespace App\Interfaces;

use App\Utils\Constants;

interface ResponseInterface
{
    public function successResponse($data = null, $message = 'Request was successful.', $meta = [], $statusCode = Constants::statusCodes['success']);
    public function errorResponse($message = 'Request failed.', $statusCode = Constants::statusCodes['error'], $errors = [], $data = null);
} 
