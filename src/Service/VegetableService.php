<?php

namespace App\Service;

use App\Entity\Vegetable;
use App\Repository\VegetableRepository;
use Doctrine\ORM\EntityManagerInterface;

class VegetableService implements FoodItemServiceInterface
{
    public function __construct(
        private VegetableRepository $vegetableRepository,
        private EntityManagerInterface $entityManager
    )
    {
    }
    
    public function add(string $name, int $weight): void
    {
        $vegetable = new Vegetable();
        $vegetable->setName($name);
        $vegetable->setQuantityInGrams($weight);

        $this->entityManager->persist($vegetable);
        $this->entityManager->flush();
    }
    
    public function list(?string $name, ?int $minWeight, ?int $maxWeight): array
    {
        return $this->vegetableRepository->findByFilters($name, $minWeight, $maxWeight);
    }

    public function search(int $id): object|null
    {
        return $this->vegetableRepository->find($id);
    }
}
