<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Repositories\Api\CategoryRepository;
use App\Http\Resources\Api\CategoryCollection;
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
}
