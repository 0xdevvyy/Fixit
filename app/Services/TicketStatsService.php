<?php

namespace App\Services;

use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;

readonly class TicketStatsService {


    // public function __construct(
    //     private Ticket $ticket
    // ) {}


    public function adminStats(): array {
        return [
            'totalTickets' => Ticket::count(),

            'openTickets' => Ticket::where('status', 'open')->count(),

            'inProgressTickets' => Ticket::where('status', 'in_progress')->count(),

            'completedTickets' => Ticket::where('status', 'completed')->count(),
        ];
    }



    public function teacherStats(User $user): array {
        return[
            'totalTickets' => Ticket::where('user_id', $user->id)->count(),

            'openTickets' => Ticket::where('user_id', $user->id)
                ->where('status', 'open')
                ->count(),

            'inProgressTickets' => Ticket::where('user_id', $user->id)
                ->where('status', 'in_progress')
                ->count(),

            'completedTickets' => Ticket::where('user_id', $user->id)
                ->where('status', 'completed')
                ->count(),
                //count of tickets creation for month
        ];
    }


    public function maintenanceStats(User $user): array {
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

            //completedTickets for months
                'completedThisMonth' => Ticket::where('status', 'completed')
                ->whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->count(),
                // dd(Carbon::now()->month)s
        ];
    }
}