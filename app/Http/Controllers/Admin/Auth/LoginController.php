<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Repositories\AdminRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    public function __construct(private readonly AdminRepository $adminRepository)
    {
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $admin = $this->adminRepository->getAdminByEmail($request->input('email'));

        if (is_null($admin) || ! Hash::check($request->input('password'), $admin->password)) {
            return $this->respondError(
                config('errors.email_or_password_invalid'),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        return $this->respondSuccess([
            'access_token' => $admin->createToken('admin_auth_token')->plainTextToken,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout(): JsonResponse
    {
        Auth::user()->tokens()->delete();

        return $this->respondSuccess(null);
    }
}
