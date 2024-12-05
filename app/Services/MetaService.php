<?php

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;

class MetaService
{
    /**
     * Build the meta information for the paginated response.
     *
     * @param LengthAwarePaginator $products
     * @return array
     */
    public function buildMeta(LengthAwarePaginator $products): array
    {
        return [
            'current_page' => $products->currentPage(),
            'first_page_url' => $products->url(1),
            'last_page' => $products->lastPage(),
            'last_page_url' => $products->url($products->lastPage()),
            'next_page_url' => $products->nextPageUrl(),
            'prev_page_url' => $products->previousPageUrl(),
            'path' => $products->path(),
            'per_page' => $products->perPage(),
            'total' => $products->total(),
        ];
    }
}
