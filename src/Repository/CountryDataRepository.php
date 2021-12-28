<?php

namespace App\Repository;

use App\Entity\CountryData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CountryData|null find($id, $lockMode = null, $lockVersion = null)
 * @method CountryData|null findOneBy(array $criteria, array $orderBy = null)
 * @method CountryData[]    findAll()
 * @method CountryData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CountryDataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CountryData::class);
    }

    // /**
    //  * @return CountryData[] Returns an array of CountryData objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CountryData
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
