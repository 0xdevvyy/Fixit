<?php

namespace App\Queries;

use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class DashboardReportRangeQuery
{
    /**
     * @return array{
     *     period: string,
     *     date: string,
     *     start: Carbon,
     *     end: Carbon
     * }
     */
    public function execute(mixed $period, mixed $date): array
    {
        $period ??= 'monthly';

        if ($date === null && $period === 'monthly') {
            $date = Carbon::now()->format('Y-m');
        } elseif ($date === null && $period === 'weekly') {
            $now = Carbon::now();
            $date = sprintf('%04d-W%02d', $now->isoWeekYear(), $now->isoWeek());
        }

        $validated = Validator::make(
            ['reportPeriod' => $period, 'reportDate' => $date],
            [
                'reportPeriod' => ['required', 'in:monthly,weekly'],
                'reportDate' => [
                    'required',
                    'string',
                    $period === 'monthly'
                        ? 'date_format:Y-m'
                        : 'regex:/^\d{4}-W(?:0[1-9]|[1-4]\d|5[0-3])$/',
                ],
            ],
        )->validate();

        $period = $validated['reportPeriod'];
        $date = $validated['reportDate'];

        if ($period === 'monthly') {
            $start = Carbon::createFromFormat('!Y-m', $date)->startOfMonth();

            return [
                'period' => $period,
                'date' => $date,
                'start' => $start,
                'end' => $start->copy()->endOfMonth(),
            ];
        }

        preg_match('/^(\d{4})-W(\d{2})$/', $date, $weekParts);
        $start = Carbon::now()
            ->setISODate((int) $weekParts[1], (int) $weekParts[2])
            ->startOfWeek();

        if ($start->isoWeekYear() !== (int) $weekParts[1]
            || $start->isoWeek() !== (int) $weekParts[2]) {
            throw ValidationException::withMessages([
                'reportDate' => 'The selected week is invalid.',
            ]);
        }

        return [
            'period' => $period,
            'date' => $date,
            'start' => $start,
            'end' => $start->copy()->endOfWeek(),
        ];
    }
}
