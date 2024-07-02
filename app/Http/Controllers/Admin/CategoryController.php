<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CategoryRepository;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Admin\CategoryRequest;
use App\Http\Resources\Admin\CategoryResource;
use App\Http\Resources\Admin\CategoryCollection;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    public function __construct(
        private readonly CategoryRepository $categoryRepository
    ) {
    }

    public function index(Request $request): JsonResponse
    {

        $category = $this->categoryRepository->getCategories();
 
        return $this->respondSuccess(new CategoryCollection($category));
    }

    public function store(CategoryRequest $request): JsonResponse
    {

        $category = $this->categoryRepository->store($request->validated());

        return $this->respondSuccess(new CategoryResource($category), Response::HTTP_CREATED);
    }
}
