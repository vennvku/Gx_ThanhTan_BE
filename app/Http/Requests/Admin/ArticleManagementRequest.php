<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\ApiRequest;

class ArticleManagementRequest extends ApiRequest
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
            'is_featured' => ['boolean']
        ];
    }

}
