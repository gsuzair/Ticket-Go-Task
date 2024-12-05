<?php

namespace App\Services;

class ResponseService
{
    /**
     * Format and structure the response data.
     *
     * @param mixed $data
     * @param array $meta
     * @return array
     */
    public function formatResponse($data, array $meta): array
    {
        return [
            'data' => $data,
            'meta' => $meta,
        ];
    }
}
