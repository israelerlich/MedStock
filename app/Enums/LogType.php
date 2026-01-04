<?php

namespace App\Enums;

enum LogType: int
{
    case INFO = 1;
    case WARNING = 2;
    case ERROR = 3;

    public function label(): string
    {
        return match($this) {
            self::INFO => "Informação",
            self::WARNING => "Aviso",
            self::ERROR => "Erro"
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(function ($type) {
            return [$type->value => $type->label()];
        })->toArray();
    }
}
