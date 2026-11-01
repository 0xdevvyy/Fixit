<?php

namespace App\Actions\Building;

use App\Enum\RoleEnum;
use App\Models\Building;
use App\Models\User;

class GetBuildingsAction
{
    /**
     * @return array{
     *     buildings: \Illuminate\Support\Collection<int, array{
     *         id: int,
     *         name: string,
     *         maintenance: array{id: int, name: string, email: string}|null,
     *         tickets_count: int
     *     }>,
     *     maintenanceUsers: \Illuminate\Database\Eloquent\Collection<int, User>,
     *     canManage: bool
     * }
     */
    public function handle(User $user): array
    {
        $canManage = $user->can('create', Building::class);

        return [
            'buildings' => Building::query()
                ->with('user:id,name,email')
                ->withCount('tickets')
                ->orderBy('name')
                ->get()
                ->map(fn (Building $building) => [
                    'id' => $building->id,
                    'name' => $building->name,
                    'maintenance' => $building->user ? [
                        'id' => $building->user->id,
                        'name' => $building->user->name,
                        'email' => $building->user->email,
                    ] : null,
                    'tickets_count' => $building->tickets_count,
                ]),
            'maintenanceUsers' => $canManage
                ? User::query()
                    ->where('role', RoleEnum::MAINTENANCE)
                    ->orderBy('name')
                    ->get(['id', 'name'])
                : new \Illuminate\Database\Eloquent\Collection,
            'canManage' => $canManage,
        ];
    }
}
