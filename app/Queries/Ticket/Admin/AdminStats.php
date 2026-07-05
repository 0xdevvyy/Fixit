<?php

namespace App\Queries\Ticket\Admin;

use App\Models\Ticket;

final class AdminStats{

    public function getAdminStats():array {
        return [
            'totalTickets' => Ticket::count(),

            'openTickets' => Ticket::where('status', 'open')->count(),

            'inProgressTickets' => Ticket::where('status', 'in_progress')->count(),

            'completedTickets' => Ticket::where('status', 'completed')->count(),
        ];
    }
}