<?php


namespace App\Services;

use App\Enum\RoleEnum;
use App\Enum\TicketCategory;
use App\Enum\TicketPriority;
use App\Enum\TicketStatus;
use App\Models\Ticket;
use App\Models\User;

class TicketService {

    // pubic function __construct()
    // {
        
    // }

    public function data(User $user): array {
        return match ($user->role){
            RoleEnum::ADMIN => [
                //get all tickets paginate 10 
                'tickets' => Ticket::with(['reporter', 'assignedTo'])
                    ->get()
                    ->map(fn($ticket) => [
                        'id' => $ticket->id,
                        'title' => $ticket->title,
                        'description' => $ticket->description,
                        'category' => $ticket->category,
                        'priority' => $ticket->priority,
                        'room' => $ticket->room,
                        'ticket_number' => $ticket->ticket_number,
                        'status' => $ticket->status,
                        'user_id' => $ticket->reporter->name,
                        'assigned_to' => $ticket->assignedTo?->name,
                    ]),
                
            ],  
            RoleEnum::TEACHER => [
                //get all recently created tickets
                //will add all of this into a query class for now it is just testing if its working
                'tickets' => $user->reportedTickets()
                    ->with(['reporter','assignedTo'])
                    ->get()
                    ->map(fn($ticket) => [
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
                    ->get()
                    ->map(fn($ticket) => [
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