<?php

namespace App\Data\Database;

use App\Document\Country;
use App\Repository\CountryRepository;

use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;


/**
 * Guarda toda la lógica de base de datos que necesitan los endpoints
 */
class Database
{   
    private CountryRepository $countryRepository;

    public function __construct(CountryRepository $countryRepository)
    {   
        /*
            @var CountryRepository

            $documentManager = $this->getDocumentManager();
        */
        $this->countryRepository = $countryRepository;
        
    }

    public function fetchCountry(String $country): Country
    {   
        // Mira si existe en la db
        if ($foundCountry = $this->countryRepository->findOneBy(['name' => ucwords($country)])) 
            return $foundCountry;

        return null;
    }


    // Lee el array de datos dentro del país.
    public function fetchCountryData(String $input, String $type): array
    {   
        
        $foundCountry = $this->countryRepository->findOneBy(['names' => $input]);

        if (!$foundCountry) return array();

        $foundCountryData = $foundCountry->getCountryData();
        
        throw new BadRequestException(json_encode($foundCountryData));

        return $foundCountryData[$type] ?  $foundCountryData[$type] : array();
    }


    /**
     * Guarda todos los nombres de un pais en la db
     */     
    public function createCountries(String $iso, array $names, array $json, String $dataType): array
    {
        if ($countries = $this->countryRepository->createCountries($names, $iso, $json, $dataType)) 
            return $countries;

        return null;
    }
}
