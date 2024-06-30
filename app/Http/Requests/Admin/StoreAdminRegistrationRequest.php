<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\ApiRequest;

class StoreAdminRegistrationRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required'],
        ];
    }
}
