<?php

namespace App\Services;

use App\Enum\RoleEnum;
use App\Models\Ticket;
use App\Models\User;

class DashboardService
{
    // i will ad a ticket Query here
    // public function __construct()
    // {
    //     throw new \Exception('Not implemented');
    // }


    public function data(User $user): array
    {
        return match ($user->role) {

            RoleEnum::ADMIN => [
                'title' => 'Admin Dashboard',

                'totalTickets' => Ticket::count(),

                'openTickets' => Ticket::where('status', 'open')->count(),

                'inProgressTickets' => Ticket::where('status', 'in_progress')->count(),

                'completedTickets' => Ticket::where('status', 'completed')->count(),
            ],

            RoleEnum::TEACHER => [
                'title' => 'Teacher Dashboard',

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
            ],

            RoleEnum::MAINTENANCE => [
                'title' => 'Technician Dashboard',

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
            ],
        };
    }
}