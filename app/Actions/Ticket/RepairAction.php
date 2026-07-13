<?php 

namespace App\Actions\Ticket;

use App\Enum\TicketStatus;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;

class RepairAction {


    public function repair(Ticket $ticket){
        DB::transaction(function () use ($ticket){
            $ticket->update([
                'status' => TicketStatus::IN_PROGRESS,
                'accepted_at' => now(),
            ]);
        });
    }
}