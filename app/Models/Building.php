<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Building extends Model
{
    /** @use HasFactory<\Database\Factories\BuildingFactory> */
    use HasFactory;

    
    public function user(): BelongsTo {
        return $this->belongsTo(User::class); //one to one
    }

    public function tickets(): HasMany {
        return $this->hasMany(Ticket::class); //one to many
    }

}
