<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketLog extends Model
{
    /** @use HasFactory<\Database\Factories\TicketLogFactory> */
    use HasFactory;


    protected $casts = [
        'old_value' => AsArrayObject::class,
        'new_value' => AsArrayObject::class,
    ];

    protected $attributes = [
        'old_value' => '[]',
        'new_value' => '[]',
    ];


    public function ticket(): BelongsTo {
        return $this->belongsTo(Ticket::class);
    }


    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
