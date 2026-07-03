<?php

namespace App\Http\Controllers;

use App\Enum\RoleEnum;
use App\Models\Ticket;
use App\Models\User;
use App\Services\DashboardService;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke(#[CurrentUser()] User $user, DashboardService $dashboard)
    {
        return Inertia::render('Dashboard', $dashboard->data($user));
    }
    
}
