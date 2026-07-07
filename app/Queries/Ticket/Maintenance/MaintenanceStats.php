<?php

namespace App\Queries\Ticket\Maintenance;

use App\Models\Ticket;
use App\Models\User;

class MaintenanceStats {
    

    public function getMaintenanceStats(User $user): array{
        return[
            'totalTickets' => $user->assignedTickets()->count(),

            'openTickets' => $user->assignedTickets()
                ->where('status', 'open')
                ->count(),

            'inProgressTickets' => $user->assignedTickets()
                ->where('status', 'in_progress')
                ->count(),

            'completedTickets' => $user->assignedTickets()
                ->where('status', 'completed')
                ->count(),
        ];
    }
}