<?php

namespace App\Actions\Building;

use App\Models\Building;

class DeleteBuildingAction
{
    public function execute(Building $building): void
    {
        $building->delete();
    }
}
