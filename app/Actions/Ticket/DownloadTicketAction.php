<?php

namespace App\Actions\Ticket;

use App\Models\Ticket;
use App\Models\TicketAttachment;
use Illuminate\Support\Facades\Storage;
use Spatie\Browsershot\Browsershot;
use Symfony\Component\HttpFoundation\StreamedResponse;

final readonly class DownloadTicketAction
{
    public function handle(Ticket $ticket): StreamedResponse
    {
        $ticket->load([
            'reporter',
            'assignedTo',
            'building',
            'afterAttachment',
            'beforeAttachment',
        ]);
        $disk = Storage::disk('public');

        $html = view('tickets.pdf', [
            'ticket' => $ticket,
            'beforeImage' => $ticket->beforeAttachment
                ? $disk->path($ticket->beforeAttachment->image_path)
                : null,
            'afterImage' => $ticket->afterAttachment
                ? $disk->path($ticket->afterAttachment->image_path)
                : null,
        ])->render();

        $pdf = Browsershot::html($html)
            ->format('A4')
            ->margins(14, 14, 14, 14)
            ->showBackground()
            ->pdf();

        return response()->streamDownload(
            static function () use ($pdf): void {
                echo $pdf;
            },
            "ticket-{$ticket->id}.pdf",
            ['Content-Type' => 'application/pdf']
        );
    }
}