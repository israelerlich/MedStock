<?php

namespace App\Enums;

enum Profession: int
{
    case MEDIC = 1;
    case NURSE = 2;
    case FINANCES = 3;

    public function label(): string
    {
        return match($this) {
            self::MEDIC => "Médico",
            self::NURSE => "Enfermeiro",
            self::FINANCES => "Financeiro"
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
            "user" => self::MEDIC,
            "admin" => self::NURSE,
            "super_admin" => self::FINANCES
        };
    }
}