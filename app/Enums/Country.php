<?php

namespace App\Enums;

enum Country: string
{
    case BRAZIL = 'br';
    case USA = 'us';
    case CANADA = 'ca';

    public function label(): string
    {
        return match($this) {
            self::BRAZIL => "Brasil",
            self::USA => "Estados Unidos",
            self::CANADA => "Canadá"
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(function ($type) {
            return [$type->value => $type->label()];
        })->toArray();
    }
}
