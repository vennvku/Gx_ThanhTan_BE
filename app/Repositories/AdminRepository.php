<?php

namespace App\Repositories;

use App\Models\Admin;

class AdminRepository
{
    public function __construct(private readonly Admin $admin)
    {
    }

    public function getAdminUser(): Admin|null
    {
        return $this->admin->query()->first();
    }

    public function getAdminByEmail(string $email): Admin|null
    {
        return $this->admin->query()->where('email', $email)->first();
    }

    public function getAdminById(int $id): Admin|null
    {
        return $this->admin->query()->where('id', $id)->first();
    }

    public function create(array $attributes): Admin
    {
        return $this->admin->create($attributes);
    }

    public function findEmailInUse(int $id, string $email): bool
    {
        return $this->admin->query()
            ->where('id', '<>', $id)
            ->where('email', $email)
            ->exists();
    }

    public function destroy(int $id): bool
    {
        return $this->admin->where('id', $id)->delete();
    }

    public function update(int $id, array $attributes): int|bool
    {
        return $this->admin->where('id', $id)->first()->fill($attributes)->save();
    }

    public function updatePasswordAdmin(int $adminId, string $password): int
    {
        return $this->admin->query()
            ->where('id', $adminId)
            ->update(['password' => $password]);
    }
}
