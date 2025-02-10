<?php

namespace App\Entity;

use App\Enum\FoodTypeEnum;
use App\Enum\WeightUnitTypeEnum;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\EdibleRepository;
use App\Traits\WeightConversionTrait;

#[ORM\Entity(repositoryClass: EdibleRepository::class)]
#[ORM\InheritanceType("SINGLE_TABLE")]
#[ORM\DiscriminatorColumn(name: "type", enumType: FoodTypeEnum::class)]
#[ORM\DiscriminatorMap(["fruit" => Fruit::class, "vegetable" => Vegetable::class])]
abstract class Edible
{
    use WeightConversionTrait;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Column(length: 255)]
    protected ?string $name = null;

    #[ORM\Column]
    protected ?int $quantity = null;

    #[ORM\Column(length: 50, enumType: WeightUnitTypeEnum::class)]
    protected ?WeightUnitTypeEnum $unit = null;

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
    
    public function getUnit(): ?WeightUnitTypeEnum
    {
        return $this->unit;
    }
    
    public function setUnit(WeightUnitTypeEnum $unit): static
    {
        $this->unit = $unit;
        
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
}