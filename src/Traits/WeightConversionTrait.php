<?php

namespace App\Traits;

use App\Enum\WeightUnitTypeEnum;

trait WeightConversionTrait
{
    public function convertToGrams(float $quantity, WeightUnitTypeEnum $unit): int
    {
        return $quantity * $unit->toGrams();
    }

    public function convertToKilograms(int $quantity, WeightUnitTypeEnum $unit): float
    {
        return $quantity * $unit->toKilograms();
    }
}