<?php

namespace App\Http\Resources;

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
            'url' => $this->resource->url,
            'name'=> $names
        ];
    }
}
