<?php

namespace App\Interfaces;

interface ResponseInterface
{
    public function successResponse($data = null, $message = 'Request was successful.', $statusCode = 200);
    public function errorResponse($message = 'Request failed.', $statusCode = 400, $data = null);
}
