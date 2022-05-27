<?php

namespace App\Repository;

use App\Document\Country;
use App\Document\CountryData;
use Doctrine\Bundle\MongoDBBundle\Repository\ServiceDocumentRepository;
use Doctrine\Bundle\MongoDBBundle\ManagerRegistry as MongoDBBundleManagerRegistry;

/**
 * @method Country|null find($id, $lockMode = null, $lockVersion = null)
 * @method Country|null findOneBy(array $criteria, array $orderBy = null)
 * @method Country[]    findAll()
 * @method Country[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CountryRepository extends ServiceDocumentRepository
{
    public function __construct(MongoDBBundleManagerRegistry $registry)
    {
        parent::__construct($registry, Country::class);
    }

    public function createCountries(array $names, string $iso, array $data, String $dataType): array {
        
        $countries = array();
        $country = new Country();
        $country->setNames($names);
        $country->setIsoCode($iso);
        $country->addCountryData($data, $dataType);

        array_push($countries, $country);

        $entityManager = $this->getDocumentManager();
        $entityManager->persist($country);
        $entityManager->flush(); 
    
        return $countries;
        
    }

    // /**
    //  * @return Country[] Returns an array of Country objects
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
    public function findOneBySomeField($value): ?Country
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
