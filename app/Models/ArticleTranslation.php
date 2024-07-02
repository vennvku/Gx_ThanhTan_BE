<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArticleTranslation extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['article_id', 'language_id', 'title', 'content', 'description'];

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
