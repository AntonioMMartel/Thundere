<?php

namespace App\Data\Database;

use App\Document\Country;
use App\Repository\CountryRepository;
use App\Repository\CountryDataRepository;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;


/**
 * Guarda toda la lógica de base de datos que necesitan los endpoints
 */
class Database
{   
    private CountryRepository $countryRepository;

    private DocumentManager $documentManager;

    public function __construct(DocumentManager $documentManager)
    {   
        $this->documentManager = $documentManager;
        /*
            @var CountryRepository

            $documentManager = $this->getDocumentManager();
            $documentManager->persist($user);
            $documentManager->flush(); 
        */
        
    }

    public function fetchCountry(String $country): Country
    {   
        // Mira si existe en la db
        if ($foundCountry = $this->countryRepository->findOneBy(['name' => ucwords($country)])) 
            return $foundCountry;

        return null;
    }


    // Lee el array de datos dentro del país.
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
     * Guarda todos los nombres de un pais en la db
     */     
    public function createCountries(String $iso, array $names, array $json): array
    {
        if ($countries = $this->countryRepository->createCountries($names, $iso, $json)) 
            return $countries;

        return null;
    }
}
