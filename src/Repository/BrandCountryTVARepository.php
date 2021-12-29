<?php

namespace App\Repository;

use App\Entity\BrandCountryTVA;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BrandCountryTVA|null find($id, $lockMode = null, $lockVersion = null)
 * @method BrandCountryTVA|null findOneBy(array $criteria, array $orderBy = null)
 * @method BrandCountryTVA[]    findAll()
 * @method BrandCountryTVA[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BrandCountryTVARepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BrandCountryTVA::class);
    }

    // /**
    //  * @return BrandCountryTVA[] Returns an array of BrandCountryTVA objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BrandCountryTVA
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
