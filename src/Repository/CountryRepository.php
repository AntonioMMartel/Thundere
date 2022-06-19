<?php

namespace App\Repository;

use App\Document\Country;
use App\Document\CountryData;
use Doctrine\Bundle\MongoDBBundle\Repository\ServiceDocumentRepository;
use Doctrine\Bundle\MongoDBBundle\ManagerRegistry as MongoDBBundleManagerRegistry;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;


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

    public function createCountry(array $names, string $iso, array $data, String $dataType): Country {
        
        $country = new Country();
        $country->setNames($names);
        $country->setIsoCode($iso);
        
        // El admin puede crear paises sin datos.
        $country->addCountryData($data, $dataType);
            
        $entityManager = $this->getDocumentManager();
        $entityManager->persist($country);
        $entityManager->flush(); 
    
        return $country;
        
    }

    public function findByName(String $name): Country {

        $dm = $this->getDocumentManager();

        $qb = $dm->createQueryBuilder(Country::class)->field('names')->in([$name]);

        $foundCountry = $qb->getQuery()->getSingleResult();

        return $foundCountry;
    }

    public function deleteCountryById($id): bool {
        $dm = $this->getDocumentManager();

        $foundCountry = $this->findOneBy(["_id" => $id]);

        if(!$foundCountry) return false;

        $dm->remove($foundCountry);
        $dm->flush();

        return true;
    }

}
