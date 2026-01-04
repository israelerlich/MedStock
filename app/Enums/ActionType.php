<?php

namespace App\Enums;

enum ActionType: int
{
    case CREATE = 1;
    case UPDATE = 2;
    case DELETE = 3;
    case VIEW = 4;

    public function label(): string
    {
        return match($this) {
            self::CREATE => "Criar",
            self::UPDATE => "Atualizar",
            self::DELETE => "Deletar",
            self::VIEW => "Visualizar"
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(function ($type) {
            return [$type->value => $type->label()];
        })->toArray();
    }
}
