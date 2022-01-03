<?php

namespace App\Repository;

use App\Entity\PromotionHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PromotionHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method PromotionHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method PromotionHistory[]    findAll()
 * @method PromotionHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PromotionHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PromotionHistory::class);
    }

    // /**
    //  * @return PromotionHistory[] Returns an array of PromotionHistory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PromotionHistory
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
