<?php

namespace App\Http\Controllers;

use App\Actions\Ticket\AcceptAction;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class TicketAcceptController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Ticket $ticket, #[CurrentUser()] User $user): RedirectResponse
    {
        Gate::authorize('accept', $ticket);
  
        AcceptAction::confirm($ticket);
        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'Successfully Accepted the Ticket',
        ]);

        return to_route('tickets.show', $ticket->id);
    }
}
