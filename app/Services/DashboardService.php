<?php

namespace App\Services;

use App\Enum\RoleEnum;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;

class DashboardService
{
    
    public function __construct(
        private TicketStatsService $ticketStats
    ){
       
    }


    public function data(User $user): array
    {
        return match ($user->role) {

            RoleEnum::ADMIN => [
                'title' => 'Admin Dashboard',
                ...$this->ticketStats->adminStats(),
                //or 'stats' => $this->ticketStats->adminStats()?
                //so that when i get the data it will look like this stats.totalTickets it is more
                
            ],
            RoleEnum::TEACHER => [
                'title' => 'Teacher Dashboard',
                ...$this->ticketStats->teacherStats($user),
                
            ],
            RoleEnum::MAINTENANCE => [
                'title' => 'Technician Dashboard',
                ...$this->ticketStats->maintenanceStats($user),
               
            ],
        };
    }
}