<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use EloquentFilter\Filterable;
use App\ModelFilters\Admin\ArticleFilter;

class Article extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Filterable;

    protected $fillable = [
        'slug',
        'photo', 
        'is_show',
        'is_featured',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'is_show' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function translations(): HasMany
    {
        return $this->hasMany(ArticleTranslation::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'article_categories');
    }

    public function modelFilter(): string
    {
        return $this->provideFilter(ArticleFilter::class);
    }
}
