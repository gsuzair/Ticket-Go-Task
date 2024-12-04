<?php

namespace App\Traits;

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
    public function successResponse($data = null, $message = 'Request was successful.', $meta = [], $statusCode = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
            'meta' => $meta,
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
    public function errorResponse($message = 'Request failed.', $statusCode = 400, $data = null)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }
}
