<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ArticleListCollection extends ResourceCollection
{

    public $collects = ArticleResource::class;

    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array<mixed>
     */
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
