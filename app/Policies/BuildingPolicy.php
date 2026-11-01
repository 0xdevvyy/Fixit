<?php

namespace App\Policies;

use App\Enum\RoleEnum;
use App\Models\Building;
use App\Models\User;

class BuildingPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role === RoleEnum::ADMIN;
    }

    public function view(User $user, Building $building): bool
    {
        return $user->role === RoleEnum::ADMIN;
    }

    public function create(User $user): bool
    {
        return $user->role === RoleEnum::ADMIN;
    }

    public function update(User $user, Building $building): bool
    {
        return $user->role === RoleEnum::ADMIN;
    }

    public function delete(User $user, Building $building): bool
    {
        return $user->role === RoleEnum::ADMIN;
    }
}
