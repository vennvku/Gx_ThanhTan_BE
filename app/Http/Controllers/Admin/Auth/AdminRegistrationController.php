<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Repositories\AdminRepository;
use App\Http\Requests\Admin\StoreAdminRegistrationRequest;
use App\Http\Resources\Admin\AdminResource;

class AdminRegistrationController extends Controller
{
    public function __construct(
        private readonly AdminRepository $adminRepository,
    ) {
    }

    public function store(StoreAdminRegistrationRequest $request): JsonResponse {

        $user = $this->adminRepository->getAdminByEmail($request->input('email'));

        if ($user) {
            return $this->respondError(
                config('errors.email_already_registered'),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        try {
            $admin = $this->adminRepository->create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
            ]);
            $admin->password = bcrypt($request->input('password'));
            $admin->save();

            return $this->respondSuccess(new AdminResource($admin));
        } catch (Throwable $exception) {
            Log::error("[Admin][verify] Error: {$exception->getMessage()}");

            return $this->respondError(
                config('errors.admin_verify_error'),
                Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
