<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Repositories\Api\CategoryRepository;
use App\Http\Resources\Api\CategoryCollection;
use App\Http\Resources\Api\CategoryResource;
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

    public function show($url): JsonResponse
    {
        $category = $this->categoryRepository->getCategoryByUrl($url);
 
        return $this->respondSuccess(new CategoryResource($category));
    }

    public function getTypeCategory(Request $request): JsonResponse
    {

        $category = $this->categoryRepository->getCategoryByUrl($request->input('slug'));

        if (is_null($category)) {
            return $this->respondError(
                config('errors.the_id_not_found'),
                Response::HTTP_NOT_FOUND,
            );
        }

        return $this->respondSuccess([
            "type" => $category->is_fixed_page,
            "category_id" => $category->id  
        ]);
    }

    public function getChainCategory($slug): JsonResponse
    {
        $category = $this->categoryRepository->getCategoryByUrl($slug);;

        if (is_null($category)) {
            return $this->respondError(
                config('errors.the_id_not_found'),
                Response::HTTP_NOT_FOUND,
            );
        }

        $result['category'] = new CategoryResource($category);

        $chain = [];

        while ($category) {
            $translations = $category->translations()->with('language')->get();
            $translationArray = [];
    
            foreach ($translations as $translation) {
                $translationArray['name'][$translation->language->code] = $translation->name;
            }
    
            $translationArray['isFixedPage'] = $category->is_fixed_page;
            $translationArray['isParent'] = $category->parent_id === null;
            $translationArray['url'] = $category->url;
    
            $chain[] = $translationArray;
            $category = $category->parent;
        }
    
        $chain = array_reverse($chain);

        foreach ($chain as $key => &$item) {
            if ($item['isParent']) {
                continue; 
            }
            $parentIndex = $key - 1;
            if ($parentIndex >= 0) {
                $item['url'] = $chain[$parentIndex]['url'] . '/' . $item['url'];
            }
        }

        $result['chain'] = $chain;
        
    
        return $this->respondSuccess($result);
    }
}
