<?php

namespace App\Repositories\Admin;

use App\Models\CategoryTranslation;
use Illuminate\Support\Collection;

class CategoryTranslationRepository
{
    public function __construct(private readonly CategoryTranslation $categoryTranslation)
    {
    } 

    public function store(array $attributes): CategoryTranslation
    {
        return $this->categoryTranslation->query()->create($attributes);
    }

    public function updateCategoryTranslation(int $categoryId, int $languageId, string $name): bool|int
    {
        return $this->categoryTranslation
                -> where('category_id', $categoryId)
                ->where('language_id', $languageId)
                ->first()
                ->update(['name' => $name]);
    }

    public function deleteCategoryTranslationById(int $id): bool|null
    {
        return $this->categoryTranslation->where('id', $id)->first()->delete();
    }

}
