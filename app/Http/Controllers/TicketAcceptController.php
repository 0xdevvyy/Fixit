<?php

namespace App\Http\Controllers;

use App\Actions\Ticket\AcceptAction;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TicketAcceptController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, #[CurrentUser()] User $user, Ticket $ticket): RedirectResponse
    {
        //need to add a policy or gate
        AcceptAction::confirm($ticket);
        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'Successfully Accepted the Ticket',
        ]);

        return to_route('tickets.show', $ticket->id);
    }
}
