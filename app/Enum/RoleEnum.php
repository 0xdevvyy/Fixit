<?php

namespace App\Enum;

enum RoleEnum :string
{
    case ADMIN = 'admin';
    case MAINTENANCE = 'maintenance';
    case TEACHER = 'teacher';
    //will add more


    public function role(): string{
        return match ($this){
            self::ADMIN => 'Admin',
            self::MAINTENANCE => 'Maintenance',
            self::TEACHER => 'Teacher'
        };
    }


    public static function value(): array {
        return array_map(fn (RoleEnum $role ) => $role->value, self::cases());
    }

    //colors 
}
