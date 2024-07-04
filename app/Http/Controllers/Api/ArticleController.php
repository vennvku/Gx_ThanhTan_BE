<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

use App\Repositories\ArticleRepository;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\ArticleCollection;

class ArticleController extends Controller
{
    public function __construct(
        private readonly ArticleRepository $articleRepository
    ) {
    }

    public function getFeaturedLatestNews(Request $request): JsonResponse
    {
        $totalArticle = 10;

        $article = $this->articleRepository->getFeaturedLatestNews($totalArticle);  
 
        return $this->respondSuccess(new ArticleCollection($article));
    }
}
