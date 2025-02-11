<?php

namespace App\Repository;

use App\Entity\Edible;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Edible>
 */
class EdibleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Edible::class);
    }

    public function findByFilters(
        ?string $type, 
        ?string $name, 
        ?int $minWeight, 
        ?int $maxWeight): array
    {
        $qb = $this->createQueryBuilder('d');

        if ($type) {
            $qb->andWhere('d INSTANCE OF :type')
               ->setParameter('type', $type);
        }

        if ($name) {
            $qb->andWhere('d.name LIKE :name')
               ->setParameter('name', '%' . $name . '%');
        }

        if ($minWeight) {
            $qb->andWhere('d.quantity >= :minWeight')
               ->setParameter('minWeight', $minWeight);
        }

        if ($maxWeight) {
            $qb->andWhere('d.quantity <= :maxWeight')
               ->setParameter('maxWeight', $maxWeight);
        }
        
        return $qb->getQuery()->getResult();
    }
}
