<?php

namespace App\Enum;

enum TicketStatus: string
{
    case PENDING = 'pending';
    case OPEN = 'open';
    case ASSIGNED = 'assigned';
    case IN_PROGRESS = 'in_progress';
    case RESOLVED = 'resolved';
    case CLOSED = 'closed';
    case COMPLETED = 'completed';


    public function status(): string {
        return match ($this){
            self::PENDING => 'Pending',
            self::OPEN => 'Open',
            self::ASSIGNED => 'Assigned',
            self::IN_PROGRESS => 'In Progress',
            self::RESOLVED => 'Resolved',
            self::CLOSED => 'Closed',
            self::COMPLETED => 'Completed',
        };
    }


    public static function value(): array {
        return array_map(fn (TicketStatus $status) => $status->value, self::cases());
    }


}
