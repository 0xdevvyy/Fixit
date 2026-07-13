<?php


namespace App\Actions\Ticket\Attachment;

use App\Actions\Ticket\RepairAction;
use App\Enum\TicketAttachmentStatus;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class BeforeUploadAction {


    public function __construct(protected RepairAction $start)
    {
        // $this->start;
    }

    public function upload(array $data,User $user, Ticket $ticket ){
        // dd($data['before_image']->store('tickets', 'public'));
        
        DB::transaction(function () use ($data,$user,$ticket){
            $folder = now()->format('Y/m'); //tickets/2026/07

            $filename = sprintf(
                'ticket-%d-before-%s.%s',
                $ticket->id,
                now()->format('YmdHis'),
                $data['before_image']->getClientOriginalExtension()
            );

            $path = $data['before_image']->storeAs(
                "tickets/{$folder}",
                $filename,
                'public'
            );

            $ticket->attachments()->create([
                'user_id'      => $user->id,
                'image_status' => TicketAttachmentStatus::BEFORE,
                'image_path'   => $path,
            ]);
           
            $this->start->repair($ticket);
            
        });
        
    }
}