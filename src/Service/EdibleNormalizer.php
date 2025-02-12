<?php

namespace App\Serializer\Normalizer;

use App\Entity\Edible;
use App\Enum\WeightUnitTypeEnum;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class EdibleNormalizer implements NormalizerInterface
{
    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof Edible;
    }

    public function normalize($object, string $format = null, array $context = []): array
    {
        $unit = $context['unit'] ?? WeightUnitTypeEnum::GRAMS->value;

        return [
            'id' => $object->getId(),
            'name' => $object->getName(),
            'quantity' => $object->getQuantity($unit),
            'type' => $object->getType(), 
            'unit' => $unit,
        ];
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            Edible::class => true,
        ];
    }
    
}
