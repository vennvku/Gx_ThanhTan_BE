<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\ApiRequest;

class MoveCategoryRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'id' => ['required', 'integer', 'exists:categories,id'],
        ];
    }

}
