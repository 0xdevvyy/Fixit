<?php

namespace App\Actions\Building;

use App\Models\Building;

class UpdateBuildingAction
{
    /**
     * @param  array{name: string, user_id?: int|null}  $data
     */
    public function execute(array $data, Building $building): Building
    {
        $building->update($data);

        return $building;
    }
}
