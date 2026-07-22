<?php

namespace App\Http\Controllers;

use App\Actions\Ticket\CreateTicket;
use App\Actions\Ticket\EditAction;
use App\Actions\Ticket\UpdateAction;
use App\Enum\TicketCategory;
use App\Enum\TicketPriority;
use App\Enum\TicketStatus;
use App\Models\Ticket;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Building;
use App\Models\User;
use App\Services\TicketService;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(#[CurrentUser()] User $user, TicketService $ticket)
    {
    
        return Inertia::render('ticket/Index', $ticket->data($user));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('ticket/Create', [
            'users' => User::select('id', 'name')
                ->where('role', 'maintenance') 
                ->get(),

            'buildings' => Building::select('id', 'name')->get(),

            'categories' => collect(TicketCategory::cases())->map(fn ($category) => [
                'value' => $category->value,
                'label' => str($category->value)->headline(),
            ]),

            'priority' => collect(TicketPriority::cases())->map(fn ($priority) => [
                'value' => $priority->value,
                'label' => str($priority->value)->headline(),
            ]),

            'status' => collect(TicketStatus::cases())->map(fn ($status) => [
                'value' => $status->value,
                'label' => str($status->value)->headline(),
            ]),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request, #[CurrentUser()] User $user, CreateTicket $action)
    {
       
        $action->execute($request->validated(), $user);

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'Ticket Succesfully Created',
        ]);

        return  to_route('tickets.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        // dd($ticket); next todo will add this in a resource
        Gate::authorize('view', $ticket);
        $ticket->load(['reporter', 'assignedTo', 'building', 'afterAttachment', 'beforeAttachment']);
        return Inertia::render('ticket/Show', [
            'ticket' => [
                'id' => $ticket->id,
                'title' => $ticket->title,
                'description' => $ticket->description,
                'category' => $ticket->category,
                'priority' => $ticket->priority,
                'status' => $ticket->status,
                'room' => $ticket->room,
                'ticket_number' => $ticket->ticket_number,

                'reporter' => $ticket->reporter?->name,
                'assigned_to' => $ticket->assignedTo?->name,
                'building' => $ticket->building?->name,

                'after' => $ticket->afterAttachment?->image_path,
                'before' => $ticket->beforeAttachment?->image_path,

                'assigned_at' => $ticket->assigned_at?->format('M d, Y'),
                'accepted_at' => $ticket->accepted_at?->format('M d, Y'),
                'completed_at' => $ticket->completed_at?->format('M d, Y'),
                'closed_at' => $ticket->closed_at?->format('M d, Y'),
                'created_at' => $ticket->created_at->format('M d, Y'),
            ],
        ]);
        // dd('this is tickets');
    }

    /**
     * Show the form for editing the specified resource.
     */
   public function edit(Ticket $ticket)
    {
        Gate::authorize('edit', $ticket);
        $ticket->load(['reporter', 'assignedTo', 'building']);

        return Inertia::render('ticket/Edit', [
            'ticket' => [
                'id' => $ticket->id,
                'title' => $ticket->title,
                'description' => $ticket->description,
                'category' => $ticket->category,
                'priority' => $ticket->priority,
                'status' => $ticket->status,
                'room' => $ticket->room,
                'ticket_number' => $ticket->ticket_number,

                'reporter' => $ticket->reporter?->name,
                
                'assigned_to' => $ticket->assigned_to,    
                'assigned_to_name' => $ticket->assignedTo?->name,
                'building' => $ticket->building->id,
                'building_name' => $ticket->building?->name,
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket, UpdateAction $action, #[CurrentUser()] User $user):RedirectResponse
    {
        // dd($request->all());
        Gate::authorize('update', $ticket);
        
        $action->handle($request->validated(), $ticket);
        
        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'Ticket Succesfully Updated',
        ]);

        return to_route('tickets.edit', $ticket->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket): RedirectResponse
    {
        Gate::authorize('delete', $ticket);
        $ticket->delete();

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'Ticket Successfully Deleted!'
        ]);

        return to_route('tickets.index');
    }
}
