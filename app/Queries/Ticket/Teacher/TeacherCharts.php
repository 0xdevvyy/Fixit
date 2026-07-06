<?php

namespace App\Queries\Ticket\Teacher;

use App\Models\Ticket;
use App\Models\User;
use App\Queries\Ticket\DashboardChartsQuery;
use Illuminate\Database\Eloquent\Builder;
use Override;

class TeacherCharts extends DashboardChartsQuery {
    

    #[Override]
    protected function baseQuery(?User $user = null): Builder
    {
        return Ticket::query()
            ->where('tickets.user_id', $user->id);
    }


}