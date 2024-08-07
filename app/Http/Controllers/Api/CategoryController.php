<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Repositories\Api\CategoryRepository;
use App\Http\Resources\Api\CategoryCollection;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(
        private readonly CategoryRepository $categoryRepository
    ) {
    }

    public function index(): JsonResponse
    {

        $category = $this->categoryRepository->getCategories();
 
        return $this->respondSuccess(new CategoryCollection($category));
    }

    public function getTypeCategory(Request $request): JsonResponse
    {

        $category = $this->categoryRepository->getCategoryByUrl($request->input('slug'));

        return $this->respondSuccess(["type" => $category->is_fixed_page]);
        
    }

}
