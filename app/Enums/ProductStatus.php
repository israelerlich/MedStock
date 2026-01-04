<?php

namespace App\Enums;

enum ProductStatus: int
{
    case ACTIVE = 1;
    case INACTIVE = 2;
    case DISCONTINUED = 3;

    public function label(): string
    {
        return match($this) {
            self::ACTIVE => "Ativo",
            self::INACTIVE => "Inativo",
            self::DISCONTINUED => "Descontinuado"
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(function ($type) {
            return [$type->value => $type->label()];
        })->toArray();
    }
}
