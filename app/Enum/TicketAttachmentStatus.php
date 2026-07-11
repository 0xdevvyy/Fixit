<?php 


namespace App\Enum;


enum TicketAttachmentStatus: string {
    
    case BEFORE = 'before';
    case AFTER = 'after';


    public function picStatus(): string {
        return match ($this) {
            self::BEFORE => 'Before',
            self::AFTER => 'After',
        };
    }


    public static function value(): array {
        return array_map(fn (TicketAttachmentStatus $picStatus) => $picStatus->value, self::cases());
    }
}