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
            'photo' => $this->resource->photo,
            'slug' => $this->resource->slug,
            'is_show' => $this->resource->is_show,
            'is_featured' => $this->resource->is_featured,
            'author' => $this->resource->createdBy,
            'created_at' => $this->resource->created_at,
            'translations' => $translationContent,
            'categories' => $this->whenLoaded('categories', function () {
                return new CategoryResource($this->categories->first());
            }), 
        ];
    }
}
