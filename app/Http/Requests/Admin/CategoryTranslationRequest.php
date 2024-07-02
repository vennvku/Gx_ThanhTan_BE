<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\ApiRequest;

class CategoryTranslationRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'category_id' => ['exists:categories,id'],
            'language_id' => ['exists:categories,id'],
            'name' => ['required'],
        ];
    }

}
