<?php

namespace App\Repositories\Admin;

use App\Models\Category;
use Illuminate\Support\Collection;

class CategoryRepository
{
    public function __construct(private readonly Category $category)
    {
    }

    public function getCategories()
    {
        return $this->category
            ->with('children')
            ->whereNull('parent_id')
            ->orderBy('position', 'asc')
            ->get();
    }

    public function getCategoriesFixed()
    {
        return $this->category
            ->where('is_fixed_page', 1)
            ->get();
    }

    public function store(array $attributes): Category
    {
        return $this->category->query()->create($attributes);
    }

    public function getCategoryById(int $id): Category|null
    {
        return $this->category->query()->whereId($id)->first();
    }

    public function getCategoryByPosition(int $position, ?int $parentId): Category|null
    {
        return $this->category->query()->where('position', $position)
                    ->where('parent_id', $parentId)
                    ->first();
    }

    public function getCategoryByUrl(string $url): Category|null
    {
        return $this->category->query()->where('url', $url)->first();
    }

    public function getLatestPosition(int $parent_id = null): Category|null
    {
        return $this->category->query()
                ->where('parent_id', $parent_id)
                ->orderByDesc('position')
                ->first();
    }

    public function updateCategoryPositions(int $parentId = null): bool|int 
    {   

        $categories = $this->category
                        ->where('parent_id', $parentId)
                        ->orderBy('position')
                        ->get();

        if ($categories->isEmpty()) {
            return 0; 
        }

        $updatedCount = 0; 

        foreach ($categories as $index => $category) {
            $category->position = $index + 1; 
            if ($category->save()) {
                $updatedCount++;
            }
        }

        return $updatedCount;
    }


    public function updateCategory(int $id, array $values): bool|int
    {
        return $this->category->where('id', $id)->first()->update($values);
    }

    public function deleteCategoryById(int $id): bool|null
    {
        return $this->category->where('id', $id)->first()->delete();
    }

}
