<?php

namespace App\Http\Controllers;

use App\Actions\Ticket\CreateTicket;
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
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(#[CurrentUser()] User $user, TicketService $ticket)
    {
        return Inertia::render('ticket/Index', $ticket->data($user));
        // dd(Auth::user()->assignedTickets()->latest()->paginate());
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
        // dd($request->validated());
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
