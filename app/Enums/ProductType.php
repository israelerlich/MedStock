<?php

namespace App\Enums;

enum ProductType: int
{
    case MEDICINE = 1;
    case EQUIPMENT = 2;
    case SUPPLY = 3;

    public function label(): string
    {
        return match($this) {
            self::MEDICINE => "Medicamento",
            self::EQUIPMENT => "Equipamento",
            self::SUPPLY => "Suprimento"
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(function ($type) {
            return [$type->value => $type->label()];
        })->toArray();
    }
}
