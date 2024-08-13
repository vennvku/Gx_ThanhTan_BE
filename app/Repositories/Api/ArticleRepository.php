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

    public function getFeaturedLatestNews($totalArticle)
    {
        $featuredArticles = $this->article->query()
                ->whereHas('categories', function ($query) {
                    $query->where('is_fixed_page', 0);
                })
                ->where('is_featured', true)
                ->where('is_show', true)
                ->latest()
                ->take($totalArticle)
                ->get();

        if ($featuredArticles->count() < $totalArticle) {
            $remainingCount = $totalArticle - $featuredArticles->count();
            $latestArticles = $this->article->query()
                ->whereHas('categories', function ($query) {
                    $query->where('is_fixed_page', 0);
                })
                ->where('is_show', true)
                ->whereNotIn('id', $featuredArticles->pluck('id'))
                ->latest()
                ->take($remainingCount)
                ->get();
    
            $result = $featuredArticles->concat($latestArticles);
        } else {
            $result = $featuredArticles;
        }

        return $result;
    }

    
    public function getTopFeaturedArticle(string $url, int $topCount)
    {
        $featuredArticles = $this->article->query()
                ->whereHas('categories', function ($query) use ($url) {
                    $query->where('url', $url);
                })
                ->where('is_featured', true)
                ->where('is_show', true)
                ->latest()
                ->take($topCount)
                ->get();

        if ($featuredArticles->count() < $topCount) {
            $remainingCount = $topCount - $featuredArticles->count();
            $latestArticles = $this->article->query()
                ->whereHas('categories', function ($query) use ($url) {
                    $query->where('url', $url);
                })
                ->where('is_show', true)
                ->whereNotIn('id', $featuredArticles->pluck('id'))
                ->latest()
                ->take($remainingCount)
                ->get();
    
            $topArticles = $featuredArticles->concat($latestArticles);
        } else {
            $topArticles = $featuredArticles;
        }

        return $topArticles;
    }

    public function getListArticleCategory(string $url, ?object $listId = null, int $perPage, int $page): LengthAwarePaginator
    {
        return $this->article->query()
            ->whereHas('categories', function ($query) use ($url) {
                $query->where('url', $url);
            })
            ->where('is_show', true)
            ->whereNotIn('id', $listId)
            ->latest()
            ->paginate(perPage: $perPage, page: $page);
    }

    public function getLatestArticles($limit)
    {
        return $this->article->query()
            ->whereHas('categories', function ($query) {
                $query->where('is_fixed_page', 0);
            })
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function getArticleById(int $id): Article|null
    {
        return $this->article->where('id', $id)->first();
    }

    public function getArticleBySlug(string $slug): Article|null
    {
        return $this->article->where('slug', $slug)->first();
    }

    

}
