<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\ApiRequest;

class CategoryRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'parent_id' => ['nullable', 'exists:categories,id'],
        ];
    }

}
