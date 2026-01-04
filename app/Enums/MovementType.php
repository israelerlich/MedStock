<?php

namespace App\Enums;

enum MovementType: int
{
    case ENTRY = 1;
    case EXIT = 2;
    case RETURN = 3;

    public function label(): string
    {
        return match($this) {
            self::ENTRY => "Entrada",
            self::EXIT => "Saída",
            self::RETURN => "Devolução"
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(function ($type) {
            return [$type->value => $type->label()];
        })->toArray();
    }
}
