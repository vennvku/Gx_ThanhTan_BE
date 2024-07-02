<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\LanguageRepository;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Admin\LanguageRequest;
use App\Http\Resources\Admin\LanguageResource;
use Symfony\Component\HttpFoundation\Response;

class LanguageController extends Controller
{
    public function __construct(
        private readonly LanguageRepository $languageRepository
    ) {
    }

    public function store(LanguageRequest $request): JsonResponse
    {

        $category = $this->languageRepository->store($request->validated());

        return $this->respondSuccess(new LanguageResource($category), Response::HTTP_CREATED);
    }
}
