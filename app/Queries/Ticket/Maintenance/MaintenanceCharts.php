<?php

namespace App\Queries\Ticket\Maintenance;

use App\Models\Ticket;
use App\Models\User;
use App\Queries\Ticket\DashboardChartsQuery;
use Illuminate\Database\Eloquent\Builder;
use Override;

class MaintenanceCharts extends DashboardChartsQuery {

    #[Override]
    protected function baseQuery(?User $user = null): Builder
    {
        return Ticket::query()
            ->where('tickets.assigned_to', $user->id);
    }
}