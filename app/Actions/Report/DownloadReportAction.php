<?php

namespace App\Actions\Report;

use App\Models\User;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Browsershot\Browsershot;
use Symfony\Component\HttpFoundation\StreamedResponse;

final readonly class DownloadReportAction
{
    /**
     * @param  array{
     *     tickets: Collection,
     *     total: int,
     *     statuses: array<string, int>,
     *     priorities: array<string, int>,
     *     categories: array<string, int>
     * }  $report
     */
    public function handle(
        User $user,
        array $report,
        string $period,
        string $date,
        CarbonInterface $start,
        CarbonInterface $end,
    ): StreamedResponse {
        $html = view('reports.pdf', [
            'user' => $user,
            'report' => $report,
            'period' => $period,
            'date' => $date,
            'start' => $start,
            'end' => $end,
        ])->render();

        $pdf = Browsershot::html($html)
            ->format('A4')
            ->margins(14, 14, 14, 14)
            ->showBackground()
            ->pdf();

        return response()->streamDownload(
            static function () use ($pdf): void {
                echo $pdf;
            },
            "ticket-report-{$period}-{$date}.pdf",
            ['Content-Type' => 'application/pdf']
        );
    }
}
