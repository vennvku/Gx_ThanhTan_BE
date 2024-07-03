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
            'photo' => ['required'],
            'is_show' => ['boolean'],
            'is_featured' => ['boolean'],
            'category_id' => ['exists:categories,id'],
            'title' => ['required'],
            'content' => ['required'],
            'description' => ['required'],
        ];
    }

}
