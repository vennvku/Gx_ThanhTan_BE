<?php

namespace App\Http\Resources\Api;

use App\Http\Resources\Traits\PaginationCollectionTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ArticleCollection extends ResourceCollection
{
    use PaginationCollectionTrait;

    public $collects = ArticleResource::class;

    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array<mixed>
     */
    public function toArray($request): array
    {
        return $this->getPaginationData();
    }
}
