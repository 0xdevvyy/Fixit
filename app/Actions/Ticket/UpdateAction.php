<?php



namespace App\Actions\Ticket;

use App\Models\Ticket;
use Illuminate\Support\Facades\DB;

class UpdateAction {

    public function handle(array $data, Ticket $ticket){

        dd($data);
        DB::transaction(function () use ($data, $ticket){
            $ticket->update($data);
        });
    }
}