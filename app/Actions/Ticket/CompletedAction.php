<?php 

namespace App\Actions\Ticket;

use App\Enum\TicketStatus;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;

class CompletedAction {


    public function complete(Ticket $ticket){
        DB::transaction(function () use ($ticket){
            $ticket->update([
                'status' => TicketStatus::COMPLETED,
                'completed_at' => now(),
            ]);
            //need to notify the reporter that the ticket is completed(resolved)
        });
    }
}