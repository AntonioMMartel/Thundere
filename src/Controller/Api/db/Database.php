<?php

namespace Api\Data;

use App\Entity\Country;
use App\Entity\CountryData;
use App\Repository\CountryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Guarda toda la lógica de base de datos que necesitan los endpoints
 */
class Database extends AbstractController
{   
    /** 
    * @var CountryRepository 
    */
    private CountryRepository $countryRepository;

    public function __construct()
    {   
        /** 
        * @var CountryRepository 
        */
        $this->countryRepository =  $this->getDoctrine()->getRepository(Country::class);
    }

    public function fetchCountry(String $country): Country
    {   
        // Mira si existe en la db
        if ($foundCountry = $this->countryRepository->findOneBy(['name' => $country])) 
            return $foundCountry;

        return null;
    }


    public function fetchCountryData(String $country, String $type): array
    {   
        $foundCountryData = $this->countryRepository->findOneBy(['name' => $country])->getCountryData();

        // Mira si existe dicho dato con dicho tipo.
        foreach ($foundCountryData as $countryData)
            if ($countryData->getDataType() == $type) 
                return $countryData->getJsonData();

        return null;
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
