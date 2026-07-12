<?php

namespace App\Actions\Ticket;

use App\Enum\TicketStatus;
use App\Models\Ticket;
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
        });
    }
}