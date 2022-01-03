<?php

namespace App\Repository;

use App\Entity\BrandCountryVat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BrandCountryVat|null find($id, $lockMode = null, $lockVersion = null)
 * @method BrandCountryVat|null findOneBy(array $criteria, array $orderBy = null)
 * @method BrandCountryVat[]    findAll()
 * @method BrandCountryVat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BrandCountryVatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BrandCountryVat::class);
    }

    // /**
    //  * @return BrandCountryVat[] Returns an array of BrandCountryVat objects
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
    public function findOneBySomeField($value): ?BrandCountryVat
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
