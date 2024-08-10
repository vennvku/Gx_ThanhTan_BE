<?php

namespace App\Repositories\Api;

use App\Models\Article;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ArticleRepository
{
    public function __construct(private readonly Article $article)
    {
    }

    // public function getFeaturedLatestNews($totalArticle): LengthAwarePaginator
    // {
    //     $featuredArticles = $this->article->query()
    //         ->where('is_featured', true)
    //         ->orderByDesc('updated_at');

    //     $featuredArticlesCount = $featuredArticles->count();

    //     if ($featuredArticlesCount < $totalArticle) {
    //         $additionalArticles = $this->article->query()
    //                                  ->where('is_featured', false)
    //                                  ->orderByDesc('updated_at')
    //                                  ->limit($totalArticle - $featuredArticlesCount);

    //         $result = $featuredArticles->union($additionalArticles);
    //     }

    //     return $result->paginate(perPage: $totalArticle);
    // }


    public function getArticleById(int $id): Article|null
    {
        return $this->article->where('id', $id)->first();
    }

    public function getArticleBySlug(string $slug): Article|null
    {
        return $this->article->where('slug', $slug)->first();
    }

}
