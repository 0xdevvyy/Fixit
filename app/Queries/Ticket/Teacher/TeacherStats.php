<?php 


namespace App\Queries\Ticket\Teacher;

use App\Models\Ticket;
use App\Models\User;

final class TeacherStats {
    public function getTeacherStats(User $user): array {
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
        ];
    }
}