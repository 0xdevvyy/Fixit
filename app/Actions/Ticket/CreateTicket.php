<?php


namespace App\Actions\Ticket;

use App\Enum\RoleEnum;
use App\Enum\TicketStatus;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use function Illuminate\Support\now;

class CreateTicket {

    public function execute(array $data, User $user){

        // dd($data);
       DB::transaction(function () use ($data, $user){
            $user->reportedTickets()->create([
                'title' => $data['title'],
                'ticket_number'=> $data['ticket_number'] ?? $this->generateTicketNumber(),
                'assigned_to' => $data['assigned_to'],
                'building_id' => $data['building_id'],
                'room' => $data['room'],
                'category' => $data['category'],
                'priority' => $data['priority'],
                'description' => $data['description'],

                'status' => $user->role === RoleEnum::ADMIN
                    ? TicketStatus::ASSIGNED
                    : TicketStatus::PENDING,

                 'assigned_at' => $user->role === RoleEnum::ADMIN
                    ? Carbon::now()
                    : null,
            ]);
            
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