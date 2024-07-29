<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Admin\CategoryRepository;
use App\Repositories\Admin\CategoryTranslationRepository;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Admin\CategoryRequest;
use App\Http\Resources\Admin\CategoryResource;
use App\Http\Resources\Admin\CategoryCollection;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Admin\MoveCategoryRequest;
use App\Http\Requests\Admin\ManagementCategoryRequest;



class CategoryController extends Controller
{
    public function __construct(
        private readonly CategoryRepository $categoryRepository,
        private readonly CategoryTranslationRepository $categoryTranslationRepository,
    ) {
    }

    public function index(Request $request): JsonResponse
    {

        $category = $this->categoryRepository->getCategories();
 
        return $this->respondSuccess(new CategoryCollection($category));
    }

    public function store(CategoryRequest $request): JsonResponse
    {
        $existingCategory = $this->categoryRepository->getCategoryByUrl($request->input('url'));
        
        if ($existingCategory) {  
            return $this->respondError(
                config('errors.this_url_is_already_in_use_by_another_category'),
                Response::HTTP_UNPROCESSABLE_ENTITY,
            );
        }

        $latestPosition = $this->categoryRepository->getLatestPosition($request->input('parent_id'));

        if ($latestPosition) {
            $positionLatest = $latestPosition->position; 
        } else {
            $positionLatest = 0;
        }

        $validatedData = $request->validated();
        $validatedData['position'] = $positionLatest + 1;

        $category = $this->categoryRepository->store($validatedData);

        $transitionViData['category_id'] = $category->id;
        $transitionViData['language_id'] = 1;
        $transitionViData['name'] = $request->nameVi;

        $transitionEnData['category_id'] = $category->id;
        $transitionEnData['language_id'] = 2;
        $transitionEnData['name'] = $request->nameEn;

        $categogyTransitionVi = $this->categoryTranslationRepository->store($transitionViData);
        $categogyTransitionEn = $this->categoryTranslationRepository->store($transitionEnData);

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
