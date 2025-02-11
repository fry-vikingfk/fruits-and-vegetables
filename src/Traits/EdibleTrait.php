<?php

namespace App\Traits;

use App\Entity\Fruit;
use App\Entity\Vegetable;
use App\Enum\FoodTypeEnum;

trait EdibleTrait
{
    public function createEdibleObject(string $type): object
    {
        return match ($type) {
            FoodTypeEnum::FRUIT->value => new Fruit(),
            FoodTypeEnum::VEGETABLE->value => new Vegetable(),
            default => throw new \InvalidArgumentException('Invalid edible type')
        };
    }
    
    public function getEdibleClassByType(string $type): string
    {
        return match ($type) {
            FoodTypeEnum::FRUIT->value => Fruit::class,
            FoodTypeEnum::VEGETABLE->value => Vegetable::class,
            default => throw new \InvalidArgumentException('Invalid edible type')
        };
    }
}