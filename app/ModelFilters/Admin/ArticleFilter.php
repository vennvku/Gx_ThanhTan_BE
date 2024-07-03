<?php

namespace App\ModelFilters\Admin;

use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\Builder;

class ArticleFilter extends ModelFilter
{
    public function keyword(string $keyword): self|Builder
    {
        return $this->whereHas('translations', function ($query) use ($keyword) {
            $query->where('title', 'like', "%$keyword%");
        });
    }
}
