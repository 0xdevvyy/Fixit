<?php

namespace App\Http\Controllers;

use App\Actions\Ticket\Attachment\AfterUploadAction;
use App\Actions\Ticket\Attachment\BeforeUploadAction;
use App\Models\TicketAttachment;
use App\Http\Requests\StoreTicketAttachmentRequest;
use App\Http\Requests\UpdateTicketAttachmentRequest;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class TicketAttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
        StoreTicketAttachmentRequest $request,
        #[CurrentUser()] User $user, 
        Ticket $ticket,
        AfterUploadAction $action,
        BeforeUploadAction $beforeAction,
        )
    {
        Gate::authorize('upload', $ticket);
        if($request->hasFile('after_image')){
            $action->upload($request->validated(), $user, $ticket);
        }
        if($request->hasFile('before_image')){
            $beforeAction->upload($request->validated(), $user, $ticket);
        }

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'Successfully Uploaded a Photo'
        ]);

        // return redirect('tickets.show');
    }

    /**
     * Display the specified resource.
     */
    public function show(TicketAttachment $ticketAttachment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TicketAttachment $ticketAttachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketAttachmentRequest $request, TicketAttachment $ticketAttachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TicketAttachment $ticketAttachment)
    {
        //
    }
}
