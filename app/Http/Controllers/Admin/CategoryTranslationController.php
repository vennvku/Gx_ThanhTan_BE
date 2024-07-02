<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CategoryTranslationRepository;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Admin\CategoryTranslationRequest;
use App\Http\Resources\Admin\CategoryTranslationResource;
use Symfony\Component\HttpFoundation\Response;

class CategoryTranslationController extends Controller
{
    public function __construct(
        private readonly CategoryTranslationRepository $categoryTranslationRepository
    ) {
    }

    public function store(CategoryTranslationRequest $request): JsonResponse
    {

        $category = $this->categoryTranslationRepository->store($request->validated());

        return $this->respondSuccess(new CategoryTranslationResource($category), Response::HTTP_CREATED);
    }
}
