<?php

namespace App\Entity;

use App\Enum\FoodTypeEnum;
use App\Traits\WeightConversionTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Fruit extends Edible
{
    use WeightConversionTrait;

    protected ?FoodTypeEnum $type = FoodTypeEnum::FRUIT;

}
