<?php

namespace App\Enum;

enum TicketStatus: string
{
    case OPEN = 'open';
    case ASSIGNED = 'assigned';
    case IN_PROGRESS = 'in_progress';
    case RESOLVED = 'resolved';
    case CLOSED = 'closed';
    case COMPLETEF = 'completed';


    public function status(): string {
        return match ($this){
            self::OPEN => 'Open',
            self::ASSIGNED => 'Assigned',
            self::IN_PROGRESS => 'In Progress',
            self::RESOLVED => 'Resolved',
            self::CLOSED => 'Closed',
            self::COMPLETEF => 'Completed',
        };
    }


    public static function value(): array {
        return array_map(fn (TicketStatus $status) => $status->value, self::cases());
    }


}
