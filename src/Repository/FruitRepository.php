<?php

namespace App\Repository;

use App\Entity\Fruit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Fruit>
 */
class FruitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fruit::class);
    }

    public function findByFilters(?string $name, ?int $minWeight, ?int $maxWeight): array
    {
        $qb = $this->createQueryBuilder('f');

        if ($name) {
            $qb->andWhere('f.name LIKE :name')
               ->setParameter('name', '%' . $name . '%');
        }

        if ($minWeight) {
            $qb->andWhere('f.quantity >= :minWeight')
               ->setParameter('minWeight', $minWeight);
        }

        if ($maxWeight) {
            $qb->andWhere('f.quantity <= :maxWeight')
               ->setParameter('maxWeight', $maxWeight);
        }
        
        return $qb->getQuery()->getResult();
    }

    //    /**
    //     * @return Fruit[] Returns an array of Fruit objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('f.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Fruit
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
