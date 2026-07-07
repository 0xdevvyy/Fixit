<?php 


namespace App\Queries\Ticket\Teacher;

use App\Models\Ticket;
use App\Models\User;

final class TeacherStats {
    public function getTeacherStats(User $user): array {
        return[
            'totalTickets' => $user->reportedTickets()->count(),

            'openTickets' => $user->reportedTickets()
                ->where('status', 'open')
                ->count(),

            'inProgressTickets' => $user->reportedTickets()
                ->where('status', 'in_progress')
                ->count(),

            'completedTickets' => $user->reportedTickets()
                ->where('status', 'completed')
                ->count(),
        ];
    }
}