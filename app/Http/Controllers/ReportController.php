<?php

namespace App\Http\Controllers;

use App\Actions\Report\DownloadReportAction;
use App\Models\User;
use App\Queries\DashboardReportRangeQuery;
use App\Queries\Ticket\ReportTicketsQuery;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReportController extends Controller
{
    public function index(
        Request $request,
        #[CurrentUser()] User $user,
        DashboardReportRangeQuery $reportRange,
        ReportTicketsQuery $reportTickets,
    ) {
        $range = $reportRange->execute(
            $request->query('reportPeriod'),
            $request->query('reportDate'),
        );
        $report = $reportTickets->execute($user, $range['start'], $range['end']);

        return Inertia::render('reports/Index', [
            'report' => [
                'total' => $report['total'],
                'statuses' => $report['statuses'],
                'priorities' => $report['priorities'],
                'categories' => $report['categories'],
            ],
            'reportPeriod' => $range['period'],
            'reportDate' => $range['date'],
            'reportLabel' => $range['period'] === 'monthly'
                ? $range['start']->format('F Y')
                : sprintf(
                    'Week %d, %d (%s - %s)',
                    $range['start']->isoWeek(),
                    $range['start']->isoWeekYear(),
                    $range['start']->format('M j'),
                    $range['end']->format('M j, Y'),
                ),
        ]);
    }

    public function download(
        Request $request,
        #[CurrentUser()] User $user,
        DashboardReportRangeQuery $reportRange,
        ReportTicketsQuery $reportTickets,
        DownloadReportAction $downloadReport,
    ) {
        $range = $reportRange->execute(
            $request->query('reportPeriod'),
            $request->query('reportDate'),
        );
        $report = $reportTickets->execute($user, $range['start'], $range['end']);

        return $downloadReport->handle(
            $user,
            $report,
            $range['period'],
            $range['date'],
            $range['start'],
            $range['end'],
        );
    }
}
