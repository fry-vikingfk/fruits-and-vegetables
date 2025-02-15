<?php

namespace App\Entity;

use App\Enum\FoodTypeEnum;
use App\Enum\WeightUnitTypeEnum;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\EdibleRepository;
use App\Traits\WeightConversionTrait;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EdibleRepository::class)]
#[ORM\InheritanceType("SINGLE_TABLE")]
#[ORM\DiscriminatorColumn(name: "type", enumType: FoodTypeEnum::class)]
#[ORM\DiscriminatorMap(["fruit" => Fruit::class, "vegetable" => Vegetable::class])]
abstract class Edible
{
    use WeightConversionTrait;
    
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "SEQUENCE")]
    #[ORM\SequenceGenerator(sequenceName: "edible_id_seq", allocationSize: 1)]
    #[ORM\Column(type: "integer")]
    protected ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 255)]
    protected ?string $name = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\Positive(message: 'Quantity must be a positive number.')]
    protected ?int $quantity = null;

    #[ORM\Column(length: 50, enumType: WeightUnitTypeEnum::class)]
    #[Assert\NotBlank(message: 'Unit must be specified.')]
    #[Assert\Choice(
        choices:[WeightUnitTypeEnum::GRAMS, WeightUnitTypeEnum::KILOGRAMS], 
        message: 'Invalid unit.'
    )]
    protected ?WeightUnitTypeEnum $unit = null;

    #[Assert\NotBlank]
    protected ?FoodTypeEnum $type = null;

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

    public function getQuantity(string $unit = WeightUnitTypeEnum::GRAMS->value): int|float
    {
        return match ($unit) {
            WeightUnitTypeEnum::GRAMS->value => $this->quantity,
            WeightUnitTypeEnum::KILOGRAMS->value => $this->convertToKilograms(
                $this->quantity,
                WeightUnitTypeEnum::from($unit)
            ),
        };
    }
    
    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;
        
        return $this;
    }
     
    public function getType(): ?FoodTypeEnum
    {
        return $this->type;
    }

    
    public function getQuantityInKilograms(): float
    {
        return $this->convertToKilograms($this->quantity, $this->unit);
    }

    public function setQuantityInGrams()
    {
        $this->quantity = $this->convertToGrams($this->quantity, $this->unit);
    }
}