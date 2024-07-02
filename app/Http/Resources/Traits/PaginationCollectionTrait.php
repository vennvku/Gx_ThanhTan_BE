<?php

namespace App\Http\Resources\Traits;

trait PaginationCollectionTrait
{
    /**
     * @return array<string, mixed>
     */
    protected function getPaginationData(): array
    {
        return [
            'current_page' => $this->resource->currentPage(),
            'from' => $this->resource->firstItem(),
            'to' => $this->resource->lastItem(),
            'last_page' => $this->resource->lastPage(),
            'per_page' => $this->resource->perPage(),
            'total' => $this->resource->total(),
            'count' => $this->count(),
            'result' => $this->collection,
        ];
    }
}
