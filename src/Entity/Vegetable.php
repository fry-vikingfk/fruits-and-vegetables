<?php

namespace App\Entity;

use App\Enum\FoodTypeEnum;
use Doctrine\ORM\Mapping as ORM;
use App\Traits\WeightConversionTrait;
use App\Repository\VegetableRepository;

#[ORM\Entity]
class Vegetable extends Edible
{
    use WeightConversionTrait;

    protected ?FoodTypeEnum $type = FoodTypeEnum::VEGETABLE;

}