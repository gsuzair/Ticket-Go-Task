<?php

namespace App\Traits;

use App\Utils\Constants;

trait ResponseTrait
{
    /**
     * Return a success response with data.
     *
     * @param mixed $data
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponse($data = null, $message = 'Request was successful.', $meta = [], $statusCode = Constants::statusCodes['success'])
    {
        return response()->json([
            'status_code' => $statusCode,
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    /**
     * Return a failure response with error message.
     *
     * @param string $message
     * @param int $statusCode
     * @param mixed $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorResponse($message = 'Request failed.', $statusCode = Constants::statusCodes['error'], $errors = [], $data = null)
    {
        return response()->json([
            'status_code' => $statusCode,
            'success' => false,
            'message' => $message,
            'errors' => $errors,
            'data' => $data,
        ], $statusCode);
    }
}
