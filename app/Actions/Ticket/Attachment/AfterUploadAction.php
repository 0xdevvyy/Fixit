<?php


namespace App\Actions\Ticket\Attachment;

use App\Enum\TicketAttachmentStatus;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AfterUploadAction {

    public function upload(array $data,User $user, Ticket $ticket ){
        // dd($data['after_image']->store('tickets', 'public'));
        DB::transaction(function () use ($data,$user,$ticket){
            $folder = now()->format('Y/m'); //tickets/2026/07

            $filename = sprintf(
                'ticket-%d-after-%s.%s',
                $ticket->id,
                now()->format('YmdHis'),
                $data['after_image']->getClientOriginalExtension()
            );

            $path = $data['after_image']->storeAs(
                "tickets/{$folder}",
                $filename,
                'public'
            );

            $ticket->attachments()->create([
                'user_id'      => $user->id,
                'image_status' => TicketAttachmentStatus::AFTER,
                'image_path'   => $path,
            ]);
        });
    }
}