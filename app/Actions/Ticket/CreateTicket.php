<?php


namespace App\Actions\Ticket;

use App\Enum\RoleEnum;
use App\Enum\TicketStatus;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\TicketAssignedNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use function Illuminate\Support\now;

class CreateTicket {


    public function __construct(protected AcceptAction $action)
    {
       
    }

    public function execute(array $data, User $user){

        // dd($data);
       DB::transaction(function () use ($data, $user){
            $ticket = $user->reportedTickets()->create([
                'title' => $data['title'],
                'ticket_number'=> $this->generateTicketNumber(),
                'assigned_to' => $data['assigned_to'],
                'building_id' => $data['building_id'],
                'room' => $data['room'],
                'category' => $data['category'],
                'priority' => $data['priority'],
                'description' => $data['description'],
      
            ]);
            if ($user->role === RoleEnum::ADMIN) {
                $this->action->confirm($ticket);
            }
            
       });
    }

    public function generateTicketNumber(): string
    {
        do {
            $number = sprintf(
                'T-%s-%s',
                now()->format('mdy'),
                strtoupper(Str::random(4))
            );
        } while (Ticket::where('ticket_number', $number)->exists());

        return $number;
    }
}