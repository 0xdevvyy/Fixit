<?php

namespace App\Actions\Ticket;

use App\Enum\TicketStatus;
use App\Models\Ticket;
use App\Notifications\TicketAssignedNotification;
use Illuminate\Support\Facades\DB;

class AcceptAction
{
    public static function confirm(Ticket $ticket): void
    {
        DB::transaction(function () use ($ticket) {
            $ticket->update([
                'status' => TicketStatus::ASSIGNED,
                'assigned_at' => now(),
            ]);

            //need to notify the reporter and maintenance

            $ticket->assignedTo?->notify(
                new TicketAssignedNotification($ticket)
            );
        });
    }
}