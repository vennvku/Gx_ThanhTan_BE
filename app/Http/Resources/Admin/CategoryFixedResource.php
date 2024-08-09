<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryFixedResource extends JsonResource
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
            'is_fixed_page' => $this->resource->is_fixed_page,
            'status' => $this->resource->status,
            'page' => $this->articles->first()
        ];
    }
}
