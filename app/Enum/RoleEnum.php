<?php

namespace App\Enum;

enum RoleEnum :string
{
    case ADMIN = 'admin';
    case MAINTENANCE = 'maintenance';
    //will add more


    public function role(): string{
        return match ($this){
            self::ADMIN => 'Admin',
            self::MAINTENANCE => 'Maintenance',
        };
    }


    public static function value(): array {
        return array_map(fn (RoleEnum $role ) => $role->value, self::cases());
    }

    //colors 
}
