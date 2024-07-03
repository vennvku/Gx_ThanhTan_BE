<?php

namespace App\Repositories;

use App\Models\ArticleCategory;
use Illuminate\Support\Collection;

class ArticleCategoryRepository
{
    public function __construct(private readonly ArticleCategory $articleCategory)
    {
    } 

    public function store(array $attributes): ArticleCategory
    {
        return $this->articleCategory->query()->create($attributes);
    }

    public function updateArticleCategory(int $id, array $values): bool|int
    {
        return $this->articleCategory->where('id', $id)->first()->update($values);
    }

    public function deleteArticleCategoryById(int $id): bool|null
    {
        return $this->articleCategory->where('id', $id)->first()->delete();
    }

}
