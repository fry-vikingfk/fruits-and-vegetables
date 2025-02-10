<?php

namespace App\Enum;

enum WeightUnitTypeEnum: string
{
    case KILOGRAMS = 'kg';
    case GRAMS = 'g';

    public function toGrams(): int
    {
        return match ($this) {
            self::KILOGRAMS => 1000,
            self::GRAMS => 1,
        };
    }
}

