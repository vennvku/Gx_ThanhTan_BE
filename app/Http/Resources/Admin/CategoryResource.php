<?php

namespace App\Http\Resources\Admin;

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

        $children = $this->resource->children->sortBy('position');

        return [
            'id' => $this->resource->id,
            'name'=> $names,
            'url'=> $this->resource->url,
            'parent_id' => $this->resource->parent_id,
            'is_parent' => $this->resource->parent_id === null, 
            'has_children' => $this->resource->children->isNotEmpty(),
            'is_fixed_page' => $this->resource->is_fixed_page,
            'status' => $this->resource->status,
            'position' => $this->resource->position,
            'created_at' => $this->resource->created_at,
            'children' => CategoryResource::collection($children),
        ];
    }
}
