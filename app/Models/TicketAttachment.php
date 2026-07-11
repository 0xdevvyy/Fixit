<?php

namespace App\Models;

use App\Enum\TicketAttachmentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketAttachment extends Model
{
    /** @use HasFactory<\Database\Factories\TicketAttachmentFactory> */
    use HasFactory;

    protected $casts = [
        'image_status' => TicketAttachmentStatus::class,
    ];

    protected $attributes = [
        'image_status' => TicketAttachmentStatus::BEFORE,
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function ticket(): BelongsTo {
        return $this->belongsTo(Ticket::class);
    }
}
