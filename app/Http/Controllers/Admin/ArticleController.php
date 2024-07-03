<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\ArticleRepository;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Admin\ArticleRequest;
use App\Http\Resources\Admin\ArticleResource;
use App\Http\Resources\Admin\ArticleCollection;
use Symfony\Component\HttpFoundation\Response;
use App\Repositories\ArticleTranslationRepository;
use App\Repositories\ArticleCategoryRepository;

use Illuminate\Support\Facades\Http;

class ArticleController extends Controller
{
    public function __construct(
        private readonly ArticleRepository $articleRepository,
        private readonly ArticleTranslationRepository $articleTranslationRepository,
        private readonly ArticleCategoryRepository $articleCategoryRepository
    ) {
    }

    public function index(Request $request): JsonResponse
    {

        $article = $this->articleRepository->getArticles(
            $request->input('limit', 10),
            $request->input('page', 1),
            $request->only(['keyword']),
        );
 
        return $this->respondSuccess(new ArticleCollection($article));
    }

    public function store(ArticleRequest $request): JsonResponse
    {

        $article = $this->articleRepository->store($request->validated());

        $articleCategory = $this->articleCategoryRepository->store([
            'article_id' => $article->id,
            'category_id' => $request->input('category_id'),
        ]);

        $articleTranslationVi = $this->articleTranslationRepository->store([
            'article_id' => $article->id,
            'language_id' => 1,
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'description' => $request->input('description'),
        ]);

        $articleTranslationEn = $this->articleTranslationRepository->store([
            'article_id' => $article->id,
            'language_id' => 2,
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'description' => $request->input('description'),
        ]);

        return $this->respondSuccess(new ArticleResource($article), Response::HTTP_CREATED);
    }

    public function show($id)
    {
        $article = $this->articleRepository->getArticleById($id);
        return $this->respondSuccess(new ArticleResource($article), Response::HTTP_CREATED);
    }
}
