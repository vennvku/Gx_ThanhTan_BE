<?php

namespace App\Repositories\Api;

use App\Models\Category;
use Illuminate\Support\Collection;

class CategoryRepository
{
    public function __construct(private readonly Category $category)
    {
    }

    public function getCategories()
    {
        return $this->category->with('children')->whereNull('parent_id')->get();
    }
}
