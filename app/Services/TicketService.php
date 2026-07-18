<?php


namespace App\Services;

use App\Enum\RoleEnum;
use App\Enum\TicketCategory;
use App\Enum\TicketPriority;
use App\Enum\TicketStatus;
use App\Http\Resources\TicketCollection;
use App\Http\Resources\TicketResource;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Request;

class TicketService {

    // pubic function __construct()
    // {
        
    // }

    public function data(User $user): array {
        return match ($user->role){
            RoleEnum::ADMIN => [
                //will add the query, like this $query->filter(new QueryBy($request->query(status)))
                'tickets' => TicketResource::collection(
                        Ticket::with(['reporter', 'assignedTo'])
                            ->when(request('search'), function ($query, $search) {
                                $query->where('ticket_number', 'like', "%{$search}%");
                            })
                             ->when(
                                TicketStatus::tryFrom(request('status')),
                                fn ($query) => $query->where('status', request('status'))
                            )
                            ->when(
                                TicketCategory::tryFrom(request('category')),
                                fn ($query) => $query->where('category', request('category'))
                            )
                            ->when(
                                TicketPriority::tryFrom(request('priority')),
                                fn ($query) => $query->where('priority', request('priority'))
                            )
                            ->latest()
                            ->paginate(10)
                            ->withQueryString()
                    ),
                'filters' => request()->only(['search','status', 'category', 'priority']),
                'filtersOption' => $this->filters(),
                
            ],  
            RoleEnum::TEACHER => [
                'tickets' => TicketResource::collection(
                    $user->reportedTickets()
                        ->when(request('search'), function ($query, $search){
                            $query->where('ticket_number', 'like', '%' . $search . '%');
                        })
                        ->when(
                            TicketStatus::tryFrom(request('status')),
                            fn ($query) => $query->where('status', request('status'))
                        )
                        ->when(
                            TicketCategory::tryFrom(request('category')),
                            fn ($query) => $query->where('category', request('category'))
                        )
                        ->when(
                            TicketPriority::tryFrom(request('priority')),
                            fn ($query) => $query->where('priority', request('priority'))
                        )
                    ->latest()
                    ->paginate()
                    ->withQueryString()
                ),
                'filters' => request()->only(['search','status', 'category', 'priority']),
                'filtersOption' => $this->filters(),
            ],
            RoleEnum::MAINTENANCE => [
                'tickets' => TicketResource::collection(
                    $user->assignedTickets()
                        ->when(request('search'), function ($query, $search){
                            $query->where('ticket_number', 'like', '%' . $search . '%');
                        })
                        ->when(
                            TicketStatus::tryFrom(request('status')),
                            fn ($query) => $query->where('status', request('status'))
                        )
                        ->when(
                            TicketCategory::tryFrom(request('category')),
                            fn ($query) => $query->where('category', request('category'))
                        )
                        ->when(
                            TicketPriority::tryFrom(request('priority')),
                            fn ($query) => $query->where('priority', request('priority'))
                        )
                        ->latest()
                        ->paginate(10)
                        ->withQueryString()
                ),
                'filters' => request()->only(['search','status', 'category', 'priority']),
                'filtersOption' => $this->filters(),
            ],
        };
    }


    public function filters(): array {
        return[
            'status' => TicketStatus::cases(),
            'priority' => TicketPriority::cases(),
            'category' => TicketCategory::cases(),
        ];
    }
    
}