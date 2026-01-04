<?php

namespace App\Enums;

enum Role: int
{
    case USER = 1;
    case ADMIN = 2;
    case SUPER_ADMIN = 3;

    public function label(): string
    {
        return match($this) {
            self::USER => "Usuário",
            self::ADMIN => "Admin",
            self::SUPER_ADMIN => "Super Admin"
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(function ($type) {
            return [$type->value => $type->label()];
        })->toArray();
    }


    public function fromString(string $value)
    {
        return match($value)
        {
            "user" => self::USER,
            "admin" => self::ADMIN,
            "super_admin" => self::SUPER_ADMIN
        };
    }
}