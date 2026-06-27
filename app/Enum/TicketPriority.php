<?php

namespace App\Enum;

enum TicketPriority: string
{
    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';
    case CRITICAL = 'critical';

    public function priority(): string {
        return match ($this) {
            self::LOW => 'Low',
            self::MEDIUM => 'Medium',
            self::HIGH => 'High',
            self::CRITICAL => 'Critical',
        };
    }


    public static function value(): array {
        return array_map(fn (TicketPriority $priority) => $priority->value, self::cases());
    }
}
