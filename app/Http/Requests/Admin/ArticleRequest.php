<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\ApiRequest;

class ArticleRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'is_show' => ['boolean'],
            'is_featured' => ['boolean'],
            'category_id' => ['exists:categories,id'],
            'photo' => ['nullable'],
            'titleVi' => ['nullable'],
            'titleEn' => ['nullable'],
            'descriptionVi' => ['nullable'],
            'descriptionEn' => ['nullable'],
            'slug' => ['nullable'],
            'contentVi' => ['nullable'],
            'contentEn' => ['nullable'],
        ];
    }

}
