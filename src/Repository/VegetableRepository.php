<?php

namespace App\Repository;

use App\Entity\Vegetable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Vegetable>
 */
class VegetableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vegetable::class);
    }

    public function findByFilters(?string $name, ?int $minWeight, ?int $maxWeight): array
    {
        $qb = $this->createQueryBuilder('v');

        if ($name) {
            $qb->andWhere('v.name LIKE :name')
               ->setParameter('name', '%' . $name . '%');
        }

        if ($minWeight) {
            $qb->andWhere('v.quantity >= :minWeight')
               ->setParameter('minWeight', $minWeight);
        }

        if ($maxWeight) {
            $qb->andWhere('v.quantity <= :maxWeight')
               ->setParameter('maxWeight', $maxWeight);
        }

        return $qb->getQuery()->getResult();
    }
    
    //    /**
    //     * @return Vegetable[] Returns an array of Vegetable objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('v')
    //            ->andWhere('v.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('v.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Vegetable
    //    {
    //        return $this->createQueryBuilder('v')
    //            ->andWhere('v.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
