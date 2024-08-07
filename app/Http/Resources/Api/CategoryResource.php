<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {

        $names = $this->translations->mapWithKeys(function ($translation) {
            return [$translation->language->code => $translation->name];
        });

        return [
            'id' => $this->resource->id,
            'name'=> $names,
            'url'=> $this->resource->url,
            'parent_id' => $this->resource->parent_id,
            'is_parent' => $this->resource->parent_id === null, 
            'is_fixed_page' => $this->resource->is_fixed_page,
            'has_children' => $this->resource->children->isNotEmpty(),
            'children' => CategoryResource::collection($this->whenLoaded('children')),
        ];
    }
}
