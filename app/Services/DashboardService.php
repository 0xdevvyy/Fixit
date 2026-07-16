<?php

namespace App\Services;

use App\Enum\RoleEnum;
use App\Models\User;
use App\Queries\Ticket\Admin\AdminCharts;
use App\Queries\Ticket\Admin\AdminStats;
use App\Queries\Ticket\Maintenance\MaintenanceCharts;
use App\Queries\Ticket\Maintenance\MaintenanceStats;
use App\Queries\Ticket\Teacher\TeacherCharts;
use App\Queries\Ticket\Teacher\TeacherStats;


class DashboardService
{
    
    public function __construct(
        private AdminStats $adminStats,
        private TeacherStats $teacherStats,
        private MaintenanceStats $maintenanceStats,
        private AdminCharts $adminCharts,
        private TeacherCharts $teacherCharts,
        private MaintenanceCharts $maintenanceCharts,

    ){
       
    }


    public function data(User $user): array
    {
        return match ($user->role) {

            RoleEnum::ADMIN => [
                'title' => 'Admin Dashboard',
                'stats' => $this->adminStats->getAdminStats(),
                'charts' =>  $this->adminCharts->getCharts(),
                // dd($this->adminCharts->getCharts())
                
            ],
            RoleEnum::TEACHER => [
                'title' => 'Teacher Dashboard',
                'stats' => $this->teacherStats->getTeacherStats($user),
                'charts' =>  $this->teacherCharts->getCharts($user),

                // dd($this->teacherCharts->getCharts($user)),
                
            ],
            RoleEnum::MAINTENANCE => [
                'title' => 'Technician Dashboard',
                'stats' =>  $this->maintenanceStats->getMaintenanceStats($user),
                'charts' => $this->maintenanceCharts->getCharts($user),
            ],
        };
    }
}