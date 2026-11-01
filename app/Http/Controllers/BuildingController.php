<?php

namespace App\Http\Controllers;

use App\Actions\Building\CreateBuildingAction;
use App\Actions\Building\DeleteBuildingAction;
use App\Actions\Building\GetBuildingsAction;
use App\Actions\Building\UpdateBuildingAction;
use App\Http\Requests\StoreBuildingRequest;
use App\Http\Requests\UpdateBuildingRequest;
use App\Models\Building;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class BuildingController extends Controller
{
    public function index(#[CurrentUser()] User $user, GetBuildingsAction $action): Response
    {
        Gate::authorize('viewAny', Building::class);

        return Inertia::render('buildings/Index', $action->handle($user));
    }

    public function store(StoreBuildingRequest $request, CreateBuildingAction $action): RedirectResponse
    {
        $action->execute($request->validated());

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'Building Successfully Created!!'
        ]);

        return to_route('buildings.index');
    }

    public function update(
        UpdateBuildingRequest $request,
        Building $building,
        UpdateBuildingAction $action,
    ): RedirectResponse {
        $action->execute($request->validated(), $building);

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'Successfully Update Building!!',
        ]);

        return to_route('buildings.index');
    }

    public function destroy(Building $building, DeleteBuildingAction $action): RedirectResponse
    {
        Gate::authorize('delete', $building);
        $action->execute($building);

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'Successfully Deleted Building!!',
        ]);
        
        return to_route('buildings.index');
    }
}
