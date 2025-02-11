<?php

namespace App\Enum;

enum FoodTypeEnum: string
{
    case FRUIT = 'fruit';
    case VEGETABLE = 'vegetable';

    public function toArray()
    {
        return [
            self::FRUIT->value,
            self::VEGETABLE->value,
        ];
    }
}
