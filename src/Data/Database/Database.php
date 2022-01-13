<?php

namespace App\Data\Database;

use App\Entity\Country;
use App\Entity\CountryData;
use App\Repository\CountryRepository;
use App\Repository\CountryDataRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

/**
 * Guarda toda la lógica de base de datos que necesitan los endpoints
 */
class Database
{   
    private CountryRepository $countryRepository;

    private CountryDataRepository $countryDataRepository;

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {   
        $this->entityManager = $entityManager;

        /*
            @var CountryRepository
        */
        $this->countryRepository =  $this->entityManager->getRepository(Country::class);


        
        $this->countryDataRepository =  $this->entityManager->getRepository(CountryData::class);
        
    }

    public function fetchCountry(String $country): Country
    {   
        // Mira si existe en la db
        if ($foundCountry = $this->countryRepository->findOneBy(['name' => ucwords($country)])) 
            return $foundCountry;

        return null;
    }


    public function fetchCountryData(String $country, String $type): array
    {   

        if (!$foundCountry = $this->countryRepository->findOneBy(['name' =>ucwords($country)]))
            return array();
        
        $foundCountryData = $foundCountry->getCountryData();
        
        // Mira si existe dicho dato con dicho tipo.
        foreach ($foundCountryData as $countryData)
            if ($countryData->getDataType() == $type) 
                return $countryData->getJsonData();


        return array();
    }

    /**
     * Guarda datos de pais en la db
     */     
    public function createCountryData(array $json, String $type) : CountryData
    {
        if ($countryData = $this->countryDataRepository->createCountryData($json, $type)) 
            return $countryData;

        return null;
    }

    /**
     * Guarda todos los nombres de un pais en la db
     */     
    public function createCountries(String $iso, array $names, CountryData $countryData): array
    {
        if ($countries = $this->countryRepository->createCountries($names, $iso, $countryData)) 
            return $countries;

        return null;
    }
}
