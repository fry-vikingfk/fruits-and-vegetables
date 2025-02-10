<?php

namespace App\Service;

use App\Entity\Fruit;
use App\Repository\FruitRepository;
use Doctrine\ORM\EntityManagerInterface;

class FruitService implements FoodItemServiceInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private FruitRepository $fruitRepository
    ) 
    {

    }

    public function add(string $name, int $grams): void
    {
        $fruit = new Fruit();
        $fruit->setName($name);
        $fruit->setQuantityInGrams($grams);

        $this->entityManager->persist($fruit);
        $this->entityManager->flush();
    }

    public function list(?string $name, ?int $minWeight, ?int $maxWeight): array
    {
        return $this->fruitRepository->findByFilters($name, $minWeight, $maxWeight);
    }

    public function search(int $id): object|null
    {
        return $this->fruitRepository->find($id);
    }
}

