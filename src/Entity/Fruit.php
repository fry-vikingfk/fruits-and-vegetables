<?php

namespace App\Entity;

use App\Enum\FoodTypeEnum;
use App\Enum\WeightUnitTypeEnum;
use App\Repository\FruitRepository;
use App\Traits\WeightConversionTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FruitRepository::class)]
class Fruit
{
    use WeightConversionTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column()]
    private ?int $quantity = null;

    #[ORM\Column(enumType: WeightUnitTypeEnum::class)]
    private ?WeightUnitTypeEnum $unit = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getQuantityInGrams(): ?int
    {
        return $this->quantity;
    }

    public function setQuantityInGrams(int $quantity): static
    {
        $this->quantity = $this->convertToGrams($quantity, $this->unit);

        return $this;
    }

    public function getUnit(): ?WeightUnitTypeEnum
    {
        return $this->unit;
    }

    public function setUnit(WeightUnitTypeEnum $unit): static
    {
        $this->unit = $unit;

        return $this;
    }

    public function getQuantityInKilograms(): float
    {
        return $this->convertToKilograms($this->quantity, $this->unit);
    }

    public function getFoodType(): string
    {
        return FoodTypeEnum::FRUIT->value;
    }
}
