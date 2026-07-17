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
                $tickets = TicketResource::collection(
                        Ticket::with(['reporter', 'assignedTo'])
                            ->when(request('search'), function ($query, $search) {
                                $query->where('ticket_number', 'like', "%{$search}%");
                            })
                            ->latest()
                            ->paginate(10)
                            ->withQueryString()
                    ),
                'tickets' => new TicketCollection($tickets),
                
            ],  
            RoleEnum::TEACHER => [
                'tickets' => $user->reportedTickets()
                    ->with(['reporter','assignedTo'])
                    ->when(Request::input('search'), function ($query, $search){
                        $query->where('ticket_number', 'like', '%' . $search . '%');
                    })
                    ->paginate()
                    ->through(fn($ticket) => [
                        'id' => $ticket->id,
                        'title' => $ticket->title,
                        'description' => $ticket->description,
                        'category' => $ticket->category,
                        'priority' => $ticket->priority,
                        'room' => $ticket->room,
                        'ticket_number' => $ticket->ticket_number,
                        'status' => $ticket->status,
                        'reporter' => $ticket->reporter->name,
                        'assigned_to' => $ticket->assignedTo?->name,
                    ]),
            ],
            RoleEnum::MAINTENANCE => [

                'tickets' => $user->assignedTickets()
                    ->with(['reporter','assignedTo'])
                    ->when(Request::input('search'), function ($query, $search){
                        $query->where('ticket_number', 'like', '%' . $search . '%');
                    })
                    ->paginate(10)
                    ->through(fn($ticket) => [
                        'id' => $ticket->id,
                        'title' => $ticket->title,
                        'description' => $ticket->description,
                        'category' => $ticket->category,
                        'priority' => $ticket->priority,
                        'room' => $ticket->room,
                        'ticket_number' => $ticket->ticket_number,
                        'status' => $ticket->status,
                        'reporter' => $ticket->reporter->name,
                        'assigned_to' => $ticket->assignedTo->name,
                    ]),
                    // ->whereIn('status', ['open', 'in_progress'])
                    // ->latest()
                    // ->paginate(10),
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