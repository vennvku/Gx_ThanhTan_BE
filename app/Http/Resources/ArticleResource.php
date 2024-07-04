<?php

namespace App\Http\Resources;

use App\Utils\Helpers;
use App\Utils\Constants;
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
            'photo' => $this->resource->photo
                        ? Helpers::generateImagePath($this->resource->photo)
                        : Helpers::generateImagePath(Constants::DEFAULT_IMAGE_PATH),
            'is_show' => $this->resource->is_show,
            'is_featured' => $this->resource->is_featured,
            'created_at' => $this->resource->created_at,
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'translations' => $translationContent,
        ];
    }
}
