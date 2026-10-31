<?php

namespace App\Queries\Ticket;

use App\Models\User;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

abstract class DashboardChartsQuery
{
    abstract protected function baseQuery(?User $user = null): Builder;

    public function getCharts(
        ?User $user = null,
        ?CarbonInterface $reportStart = null,
        ?CarbonInterface $reportEnd = null,
    ): array
    {
        $reportStart ??= now()->startOfMonth();
        $reportEnd ??= $reportStart->copy()->endOfMonth();

        return [
            'ticketsPerDay' => $this->ticketsPerDay($user, $reportStart, $reportEnd),
            'statusBreakdown' => $this->statusBreakdown($user, $reportStart, $reportEnd),
            'ticketsByBuilding' => $this->ticketsByBuilding($user, $reportStart, $reportEnd),
        ];
    }

    protected function ticketsPerDay(
        ?User $user,
        CarbonInterface $reportStart,
        CarbonInterface $reportEnd,
    )
    {
        return $this->baseQuery($user)
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total')
            )
            ->whereBetween('created_at', [$reportStart, $reportEnd])
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(fn ($item) => [
                'date' => $item->date,
                'total' => (int) $item->total,
            ])
            ->values()
            ->toArray();
    }

    protected function statusBreakdown(
        ?User $user,
        CarbonInterface $reportStart,
        CarbonInterface $reportEnd,
    ): array
    {
        $query = $this->baseQuery($user)
            ->whereBetween('created_at', [$reportStart, $reportEnd]);

        return [
            'open' => (clone $query)->where('status', 'open')->count(),
            'in_progress' => (clone $query)->where('status', 'in_progress')->count(),
            'completed' => (clone $query)->where('status', 'completed')->count(),
        ];
    }

    protected function ticketsByBuilding(
        ?User $user,
        CarbonInterface $reportStart,
        CarbonInterface $reportEnd,
    )
    {
        return $this->baseQuery($user)
            ->select(
                'buildings.name',
                DB::raw('COUNT(tickets.id) as total')
            )
            ->join('buildings', 'tickets.building_id', '=', 'buildings.id')
            ->whereBetween('tickets.created_at', [$reportStart, $reportEnd])
            ->groupBy('buildings.id', 'buildings.name')
            ->orderByDesc('total')
            ->get()
            ->map(fn ($item) => [
                'name' => $item->name,
                'total' => (int) $item->total,
            ])
            ->values()
            ->toArray();
    }

  
}