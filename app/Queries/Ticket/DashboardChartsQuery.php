<?php

namespace App\Queries\Ticket;

use App\Models\User;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

abstract class DashboardChartsQuery
{
    abstract protected function baseQuery(?User $user = null): Builder;

    public function getCharts(?User $user = null, ?CarbonInterface $month = null): array
    {
        $month ??= now();

        return [
            'ticketsPerDay' => $this->ticketsPerDay($user, $month),
            'statusBreakdown' => $this->statusBreakdown($user, $month),
            'ticketsByBuilding' => $this->ticketsByBuilding($user, $month),
        ];
    }

    protected function ticketsPerDay(?User $user, CarbonInterface $month)
    {
        return $this->baseQuery($user)
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total')
            )
            ->whereBetween('created_at', [
                $month->copy()->startOfMonth(),
                $month->copy()->endOfMonth(),
            ])
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    protected function statusBreakdown(?User $user, CarbonInterface $month): array
    {
        $query = $this->baseQuery($user)
            ->whereBetween('created_at', [
                $month->copy()->startOfMonth(),
                $month->copy()->endOfMonth(),
            ]);

        return [
            'open' => (clone $query)->where('status', 'open')->count(),
            'in_progress' => (clone $query)->where('status', 'in_progress')->count(),
            'completed' => (clone $query)->where('status', 'completed')->count(),
        ];
    }

    protected function ticketsByBuilding(?User $user, CarbonInterface $month)
    {
        return $this->baseQuery($user)
            ->select(
                'buildings.name',
                DB::raw('COUNT(tickets.id) as total')
            )
            ->join('buildings', 'tickets.building_id', '=', 'buildings.id')
            ->whereBetween('tickets.created_at', [
                $month->copy()->startOfMonth(),
                $month->copy()->endOfMonth(),
            ])
            ->groupBy('buildings.id', 'buildings.name')
            ->orderByDesc('total')
            ->get();
    }

  
}