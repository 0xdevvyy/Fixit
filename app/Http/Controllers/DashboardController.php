<?php

namespace App\Http\Controllers;

use App\Enum\RoleEnum;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke(#[CurrentUser()] User $user)
    {
            //should i create a service for the data? ahhh i still cant decide
           return match ($user->role) {
            RoleEnum::ADMIN => Inertia::render('admin/Dashboard', [
                'totalTickets' => Ticket::count(),
                'openTickets' => Ticket::where('status', 'open')->count(),
                'inProgressTickets' => Ticket::where('status', 'in_progress')->count(),
                'completedTickets' => Ticket::where('status', 'completed')->count(),
            ]),

            RoleEnum::TEACHER => Inertia::render('Teacher/Dashboard', [
                // teacher data
            ]),

            RoleEnum::MAINTENANCE => Inertia::render('Technician/Dashboard', [
                // technician data
            ]),
            default => abort(403),
        };
    }
    
}
