<?php

namespace App\Controller\Api;

use App\Entity\Country;
use App\Entity\CountryData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * 
 * 
 */
class Database extends AbstractController
{   


    public function searchForCountry(String $country): bool
    {   
        /** 
        * @var CountryRepository 
        */
        $countryRepository = $this->getDoctrine()->getRepository(Country::class);

        // Mira si existe en la db
        if ($foundCountry = $countryRepository->findOneBy(['name' => $country])) return true;

        return false;
    }

    /**
     * Guarda datos de pais en la db
     */     
    public function createCountryData(String $json) : bool
    {
        /** 
            * @var DataCountryRepository 
        */
        $countryDataRepository = $this->getDoctrine()->getRepository(CountryData::class);

        $countryData = $countryDataRepository->createCountryData($json);

        return true;

    }

    /**
     * Guarda todos los nombres de un pais en la db
     */     
    public function createCountries(String $iso, array $names, String $countryData): bool
    {   
        /** 
        * @var CountryRepository 
        */
        $countryRepository = $this->getDoctrine()->getRepository(Country::class);
        $countryRepository->createCountries($names, $iso, $countryData);
        return true;

    }
}
