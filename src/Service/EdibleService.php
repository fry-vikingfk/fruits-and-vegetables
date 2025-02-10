<?php

namespace App\Service;

use App\Entity\Edible;
use App\Repository\EdibleRepository;
use App\Traits\EdibleTrait;
use Doctrine\ORM\EntityManagerInterface;

class EdibleService
{
    use EdibleTrait;

    public function __construct(
        private readonly EdibleRepository $edibleRepository,
        private readonly EntityManagerInterface $entityManager
    )
    {
    }

    public function list(
        ?string $type, 
        ?string $name, 
        ?int $minWeight, 
        ?int $maxWeight
    ): array
    {
        return $this->edibleRepository->findByFilters(
            type: $type,
            name: $name,
            minWeight: $minWeight,
            maxWeight: $maxWeight
        );
    }

    public function search(int $id): ?object
    {
        return $this->edibleRepository->find($id);
    }

    public function add(Edible $edible): void
    {
        $this->entityManager->persist($edible);
        $this->entityManager->flush();
    }
}