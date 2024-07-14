<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\AdminDetailResource;
use App\Repositories\AdminRepository;
use App\Utils\Constants;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    public function __construct(
        private readonly AdminRepository $adminRepository,
    ) {
    }

    public function profile(): JsonResponse
    {
        $admin = $this->adminRepository->getAdminById(Auth::id());

        return $this->respondSuccess(new AdminDetailResource($admin));
    }
}
