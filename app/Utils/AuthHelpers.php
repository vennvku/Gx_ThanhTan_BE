<?php

namespace App\Utils;

use App\Models\Admin;

class AuthHelpers
{
    public static function getUserId(): int|null
    {
        $admin = Admin::query()->latest()->first();

        return auth()->id() ?? ($admin->id ?? null);
    }
}
