<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

use App\Repositories\Api\ArticleRepository;
use App\Repositories\Api\CategoryRepository;
use App\Http\Resources\Api\ArticleResource;
use App\Http\Resources\Api\ArticleCollection;

class ArticleController extends Controller
{
    public function __construct(
        private readonly ArticleRepository $articleRepository,
        private readonly CategoryRepository $categoryRepository
    ) {
    }

    public function getFeaturedLatestNews(Request $request): JsonResponse
    {
        $totalArticle = 15;

        $article = $this->articleRepository->getFeaturedLatestNews($totalArticle);  
 
        return $this->respondSuccess(new ArticleCollection($article));
    }

    public function showDetailArticle($slug): JsonResponse
    {  

        $articleBySlug = $this->articleRepository->getArticleBySlug($slug);
 
        return $this->respondSuccess(new ArticleResource($articleBySlug));
    }

    public function showDetailFixedPage($slug): JsonResponse
    {  

        $category = $this->categoryRepository->getCategoryByUrl($slug);

        if (is_null($category)) {
            return $this->respondError(
                config('errors.the_id_not_found'),
                Response::HTTP_NOT_FOUND,
            );
        }

        $idArticle = $category->articles->first()->id;

        $article = $this->articleRepository->getArticleById($idArticle);

        if (is_null($article)) {
            return $this->respondError(
                config('errors.the_id_not_found'),
                Response::HTTP_NOT_FOUND,
            );
        }
 
        return $this->respondSuccess(new ArticleResource($article));
    }

}
