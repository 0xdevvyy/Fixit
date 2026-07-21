<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'category' => $this->category,
            'priority' => $this->priority,
            'room' => $this->room,
            'ticket_number' => $this->ticket_number,
            'status' => $this->status,
            'reporter' => $this->reporter->name,
            'assigned_to' => $this->assignedTo?->name,
            'created_at' => $this->created_at,
            
        ];
    }
}
