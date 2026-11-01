<?php

namespace App\Actions\Building;

use App\Models\Building;

class CreateBuildingAction
{
    /**
     * @param  array{name: string, user_id?: int|null}  $data
     */
    public function execute(array $data): Building
    {
        return Building::create($data);
    }
}
