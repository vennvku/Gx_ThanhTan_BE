<?php

namespace App\Repositories;

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

    public function updateCategoryTranslation(int $id, array $values): bool|int
    {
        return $this->categoryTranslation->where('id', $id)->first()->update($values);
    }

    public function deleteCategoryTranslationById(int $id): bool|null
    {
        return $this->categoryTranslation->where('id', $id)->first()->delete();
    }

}
