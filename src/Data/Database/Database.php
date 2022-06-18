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
        if ($foundCountry = $this->countryRepository->findOneBy(['names' => ucwords($country)])) 
            return $foundCountry;

        return null;
    }


    // Lee el array de datos dentro del país.
    public function fetchCountryData(String $input, String $type): array
    {   
        $foundCountry = $this->countryRepository->findOneBy(['names' => $input]);

        if (!$foundCountry) return array();

        $foundCountryData = $foundCountry->getCountryData();

        return $foundCountryData[$type] ?  $foundCountryData[$type] : array();
    }


    /**
     * Crea un nuevo pais.
     */     
    public function createCountry(String $iso, array $names, array $json, String $dataType): Country
    {
        if ($country = $this->countryRepository->createCountry($names, $iso, $json, $dataType)) 
            return $country;

        return null;
    }
}
