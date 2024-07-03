<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {

        $this->resource->load(['categories']);

        $translationContent = $this->translations->mapWithKeys(function ($translation) {
            return [
                $translation->language->code => [
                    'title' => $translation->title,
                    'content' => $translation->content,
                    'description' => $translation->description,
                ]
            ];
        });
 
        return [
            'id' => $this->resource->id,
            'photo' => $this->photo,
            'is_show' => $this->is_show,
            'is_featured' => $this->is_featured,
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'translations' => $translationContent,
        ];
    }
}
