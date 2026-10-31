<?php

namespace App\Queries\Ticket;

use App\Enum\RoleEnum;
use App\Enum\TicketCategory;
use App\Enum\TicketPriority;
use App\Enum\TicketStatus;
use App\Models\Ticket;
use App\Models\User;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Collection;

class ReportTicketsQuery
{
    /**
     * @return array{
     *     tickets: Collection<int, Ticket>,
     *     total: int,
     *     statuses: array<string, int>,
     *     priorities: array<string, int>,
     *     categories: array<string, int>
     * }
     */
    public function execute(User $user, CarbonInterface $start, CarbonInterface $end): array
    {
        $query = Ticket::query()
            ->with(['reporter:id,name', 'assignedTo:id,name', 'building:id,name'])
            ->whereBetween('created_at', [$start, $end]);

        match ($user->role) {
            RoleEnum::ADMIN => null,
            RoleEnum::TEACHER => $query->where('user_id', $user->id),
            RoleEnum::MAINTENANCE => $query->where('assigned_to', $user->id),
        };

        $tickets = $query->orderBy('created_at')->get();

        return [
            'tickets' => $tickets,
            'total' => $tickets->count(),
            'statuses' => $this->countBy($tickets, 'status', TicketStatus::cases()),
            'priorities' => $this->countBy($tickets, 'priority', TicketPriority::cases()),
            'categories' => $this->countBy($tickets, 'category', TicketCategory::cases()),
        ];
    }

    /**
     * @param  Collection<int, Ticket>  $tickets
     * @param  array<\BackedEnum>  $cases
     * @return array<string, int>
     */
    private function countBy(Collection $tickets, string $attribute, array $cases): array
    {
        $counts = [];

        foreach ($cases as $case) {
            $counts[$case->value] = 0;
        }

        foreach ($tickets as $ticket) {
            $value = $ticket->{$attribute}?->value;
            if ($value !== null) {
                $counts[$value] = ($counts[$value] ?? 0) + 1;
            }
        }

        return $counts;
    }
}
