<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Admin\CategoryRepository;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Admin\CategoryRequest;
use App\Http\Resources\Admin\CategoryResource;
use App\Http\Resources\Admin\CategoryCollection;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Admin\MoveCategoryRequest;

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

    public function update(int $id, CategoryRequest $request): JsonResponse
    {
        $category = $this->categoryRepository->getCategoryById($id);

        if (is_null($category)) {
            return $this->respondError(
                config('errors.the_id_not_found'),
                Response::HTTP_NOT_FOUND,
            );
        }

        $this->categoryRepository->updateCategory($id, $request->validated());
        $category = $this->categoryRepository->getCategoryById($id);

        return $this->respondSuccess(new CategoryResource($category));
    }

    public function moveUpCategory(MoveCategoryRequest $request) {

        $id = $request->id;

        $category = $this->categoryRepository->getCategoryById($id);
        if (is_null($category)) {
            return $this->respondError(
                config('errors.the_id_not_found'),
                Response::HTTP_NOT_FOUND,
            );
        }

        $previousCategory = $this->categoryRepository
                            ->getCategoryByPosition($category->position - 1, $category->parent_id);

        if (is_null($previousCategory)) {
            return $this->respondError(
                config('errors.the_id_not_found'),
                Response::HTTP_NOT_FOUND,
            );
        }

        $this->categoryRepository->updateCategory($category->id, ['position' => $category->position - 1]);
        $this->categoryRepository->updateCategory($previousCategory->id, ['position' => $previousCategory->position + 1]);

        return $this->respondSuccess(null);
    }

    public function moveBottomCategory(MoveCategoryRequest $request) {

        $id = $request->id;

        $category = $this->categoryRepository->getCategoryById($id);
        if (is_null($category)) {
            return $this->respondError(
                config('errors.the_id_not_found'),
                Response::HTTP_NOT_FOUND,
            );
        }

        $nextCategory = $this->categoryRepository
                            ->getCategoryByPosition($category->position + 1, $category->parent_id);

        if (is_null($nextCategory)) {
            return $this->respondError(
                config('errors.the_id_not_found'),
                Response::HTTP_NOT_FOUND,
            );
        }

        $this->categoryRepository->updateCategory($category->id, ['position' => $category->position + 1]);
        $this->categoryRepository->updateCategory($nextCategory->id, ['position' => $nextCategory->position - 1]);

        return $this->respondSuccess(null);
    }


    

}
