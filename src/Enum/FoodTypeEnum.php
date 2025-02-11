<?php

namespace App\Enum;

enum FoodTypeEnum: string
{
    case FRUIT = 'fruit';
    case VEGETABLE = 'vegetable';

    public static function toArray(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}
