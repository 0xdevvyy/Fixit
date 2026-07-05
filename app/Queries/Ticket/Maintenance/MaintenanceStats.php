<?php

namespace App\Queries\Ticket\Maintenance;

use App\Models\Ticket;
use App\Models\User;

class MaintenanceStats {
    

    public function getMaintenanceStats(User $user): array{
        return[
            'totalTickets' => Ticket::where('assigned_to', $user->id)->count(),

            'openTickets' => Ticket::where('assigned_to', $user->id)
                ->where('status', 'open')
                ->count(),

            'inProgressTickets' => Ticket::where('assigned_to', $user->id)
                ->where('status', 'in_progress')
                ->count(),

            'completedTickets' => Ticket::where('assigned_to', $user->id)
                ->where('status', 'completed')
                ->count(),
        ];
    }
}