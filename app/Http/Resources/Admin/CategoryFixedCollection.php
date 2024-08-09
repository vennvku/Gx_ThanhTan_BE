<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryFixedCollection extends ResourceCollection
{
    public $collects = CategoryFixedResource::class;

    /**
     * Transform the resource collection into an array.
     *
     * @param  Request  $request
     * @return array<mixed>
     */
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
