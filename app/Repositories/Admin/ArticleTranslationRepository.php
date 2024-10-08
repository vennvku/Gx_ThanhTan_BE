<?php

namespace App\Repositories\Admin;

use App\Models\ArticleTranslation;
use Illuminate\Support\Collection;

class ArticleTranslationRepository
{
    public function __construct(private readonly ArticleTranslation $articleTranslation)
    {
    } 

    public function store(array $attributes): ArticleTranslation
    {
        return $this->articleTranslation->query()->create($attributes);
    }

    public function updateArticleTranslation(int $id, int $language_id, array $values): bool|int
    {
        return $this->articleTranslation
                ->where('article_id', $id)
                ->where('language_id', $language_id)
                ->first()
                ->update($values);
    }

    public function deleteArticleTranslationById(int $id): bool|null
    {
        return $this->articleTranslation->where('id', $id)->first()->delete();
    }

}
