<?php

namespace App\Enum;

enum TicketCategory: string
{
    case AIRCON = 'aircon';
    //will add more



    public function category(): string
    {
        return match ($this) {
            self::AIRCON => 'Aircon',
        };
    }

    public static function values(): array 
    {
        return array_map(fn (TicketCategory $category) => $category->value, self::cases());
    }

}
