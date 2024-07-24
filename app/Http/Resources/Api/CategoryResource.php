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
            'tes' => 'test',
            'name'=> $names,
            'url'=> $this->url,
            'parent_id' => $this->parent_id,
            'is_parent' => $this->parent_id === null, 
            'has_children' => $this->children->isNotEmpty(),
            'children' => CategoryResource::collection($this->whenLoaded('children')),
        ];
    }
}
