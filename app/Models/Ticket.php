<?php

namespace App\Models;

use App\Enum\TicketCategory;
use App\Enum\TicketPriority;
use App\Enum\TicketStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

// #[Fillable([''])]
class Ticket extends Model
{
    /** @use HasFactory<\Database\Factories\TicketFactory> */
    use HasFactory;


    protected $casts = [
    
        'category' => TicketCategory::class,
        'status' => TicketStatus::class,
        'priority' => TicketPriority::class,

    ];

    protected $attributes = [
        'category' => TicketCategory::AIRCON,
        'status' => TicketStatus::OPEN,
        'priority' => TicketPriority::MEDIUM,
    ];



    //note: this can still all change
    public function reporter(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    //is the naming correct? can it be maintenance or technician?
    public function assignedTo(): BelongsTo {
        return $this->belongsTo(User::class, 'assigned_to');
    }


    public function building(): BelongsTo {
        return $this->belongsTo(Building::class);
    }


    public function logs(): HasMany {
        return $this->hasMany(TicketLog::class);
    }
}
