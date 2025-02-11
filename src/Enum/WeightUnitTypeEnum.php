<?php

namespace App\Enum;

enum WeightUnitTypeEnum: string
{
    public const VALID_CHOICES = ['kg', 'g'];
    
    case KILOGRAMS = 'kg';
    case GRAMS = 'g';

    public function toGrams(): int
    {
        return match ($this) {
            self::KILOGRAMS => 1000,
            self::GRAMS => 1,
        };
    }

    public static function toArray(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}

