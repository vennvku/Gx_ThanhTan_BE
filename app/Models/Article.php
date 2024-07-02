<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'photo', 
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
}
