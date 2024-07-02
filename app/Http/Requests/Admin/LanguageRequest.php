<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\ApiRequest;

class LanguageRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'code' => ['required'],
            'name' => ['required'],
        ];
    }

}
