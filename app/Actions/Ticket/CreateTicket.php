<?php


namespace App\Actions\Ticket;

use App\Enum\RoleEnum;
use App\Enum\TicketStatus;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CreateTicket {

    public function execute(array $data, User $user){

        dd($data);
       DB::transaction(function () use ($data, $user){
            $user->reportedTickets()->create([
                ...$data,
                'status' => $user->role === RoleEnum::ADMIN
                    ? TicketStatus::OPEN
                    : TicketStatus::PENDING,
            ]);
       });
    }
}