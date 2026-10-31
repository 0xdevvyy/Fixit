<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Queries\DashboardReportRangeQuery;
use App\Services\DashboardService;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke(
        Request $request,
        #[CurrentUser()] User $user,
        DashboardService $dashboard,
        DashboardReportRangeQuery $reportRange,
    )
    {
        $range = $reportRange->execute(
            $request->query('reportPeriod'),
            $request->query('reportDate'),
        );

        return Inertia::render('Dashboard', [
            ...$dashboard->data($user, $range['start'], $range['end']),
            'reportPeriod' => $range['period'],
            'reportDate' => $range['date'],
        ]);
    }
}
