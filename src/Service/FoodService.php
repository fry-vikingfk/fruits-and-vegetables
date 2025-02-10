<?php
declare(strict_types=1);

namespace App\Service;

use App\Enum\FoodTypeEnum;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final class FoodService implements FoodServiceInterface
{
    public function __construct(
        private FoodItemServiceInterface $fruitService,
        private FoodItemServiceInterface $vegetableService
    ) {
    }
   
    public function list(?string $type, ?string $name, ?int $minWeight, ?int $maxWeight): array
    {
        if (!$type) {
            return array_merge(
                $this->fruitService->list($name, $minWeight, $maxWeight),
                $this->vegetableService->list($name, $minWeight, $maxWeight)
            );
        }
        
        return $this->serviceFactory($type)->list($name, $minWeight, $maxWeight);
    }

    public function search(string $type, int $id): object|null
    {
        return $this->serviceFactory($type)->search($id);
    }

    public function add(string $type, string $name, int $weight): void
    {
        $this->serviceFactory($type)->add($name, $weight);
    }

    private function serviceFactory(string $type): FoodItemServiceInterface
    {
        return match ($type) {
            FoodTypeEnum::FRUIT->value => $this->fruitService,
            FoodTypeEnum::VEGETABLE->value => $this->vegetableService,
            default => throw new BadRequestHttpException('Invalid type. Use "fruit" or "vegetable".'),
        };
    }
}
