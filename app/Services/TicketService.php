<?php


namespace App\Services;

use App\Enum\RoleEnum;
use App\Enum\TicketCategory;
use App\Enum\TicketPriority;
use App\Enum\TicketStatus;
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
                //get all tickets paginate 10 
                'tickets' => Ticket::with(['reporter', 'assignedTo'])
                    
                    ->when(Request::input('search'), function ($query, $search){
                        $query->where('ticket_number', 'like', '%' . $search . '%');
                    })
                    ->latest()
                    ->paginate(10)
                    ->withQueryString()
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
            RoleEnum::TEACHER => [
                //get all recently created tickets
                //will add all of this into a query class for now it is just testing if its working
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
                //get all tickets that is assigned to me 
                //will add a query, and in the front end a status button 
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