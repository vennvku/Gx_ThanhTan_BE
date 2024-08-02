<?php

namespace App\Http\Controllers\Admin;

use App\Utils\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Admin\ArticleRepository;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Admin\ArticleRequest;
use App\Http\Resources\Admin\ArticleResource;
use App\Http\Resources\Admin\ArticleCollection;
use Symfony\Component\HttpFoundation\Response;
use App\Repositories\Admin\ArticleTranslationRepository;
use App\Repositories\Admin\ArticleCategoryRepository;

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

        // return response()->json([
        //     "status" => "sucess",
        //     "photo" => $request->input('photo'),
        //     "titleVi" => $request->input('titleVi'),
        //     "titleEn" => $request->input('titleEn'),
        //     "slug" => $request->input('slug'),
        //     "contentVi" => $request->input('contentVi'),
        //     "contentEn" => $request->input('contentEn'),
        //     "is_show" => $request->input('is_show'),
        //     "is_featured" => $request->input('is_featured'),
        //     "category_id" => $request->input('category_id')
        // ]);

        $articleBySlug = $this->articleRepository->getArticleBySlug($request->input('slug'));

        if ($articleBySlug) {
            return $this->respondError(
                config('errors.article_already_exists'),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        if($request->input('photo')) {

        } else {
            $photoUrl = "placeholder.png";
        }

        // return response()->json([
        //     "status" => "sucess",
        //     "is_show" => $request->input('is_show'),
        //     "is_featured" => $request->input('is_featured'),
        // ]);

        $article = $this->articleRepository->store([
            'slug' => $request->input('slug'),
            'photo' => $photoUrl,
            'is_show' => $request->input('is_show'),
            'is_featured' => $request->input('is_featured'),
        ]);

        $articleCategory = $this->articleCategoryRepository->store([
            'article_id' => $article->id,
            'category_id' => $request->input('category_id'),
        ]);

        $articleTranslationVi = $this->articleTranslationRepository->store([
            'article_id' => $article->id,
            'language_id' => 1,
            'title' => $request->input('titleVi'),
            'content' => $request->input('contentVi'),
            'description' => $request->input('descriptionVi'),
        ]);

        $articleTranslationEn = $this->articleTranslationRepository->store([
            'article_id' => $article->id,
            'language_id' => 2,
            'title' => $request->input('titleEn'),
            'content' => $request->input('contentEn'),
            'description' => $request->input('descriptionEn'),
        ]);

        return $this->respondSuccess(new ArticleResource($article), Response::HTTP_CREATED);
    }

    public function show($id)
    {
        $article = $this->articleRepository->getArticleById($id);
        return $this->respondSuccess(new ArticleResource($article));
    }
}
