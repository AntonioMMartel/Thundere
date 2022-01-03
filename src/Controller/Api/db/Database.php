<?php

namespace Api\Data;


use App\Entity\Country;
use App\Entity\CountryData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Guarda toda la lógica de base de datos que necesitan los endpoints
 */
class Database extends AbstractController
{
    public function countryExists(String $country): bool
    {   
        /** 
        * @var CountryRepository 
        */
        $countryRepository = $this->getDoctrine()->getRepository(Country::class);

        // Mira si existe en la db
        if ($foundCountry = $countryRepository->findOneBy(['name' => $country])) return true;

        return false;
    }


    public function countryDataExists(String $country, String $type): bool
    {
        /** 
        * @var CountryRepository 
        */
        $countryRepository = $this->getDoctrine()->getRepository(Country::class);
        $foundCountry = $countryRepository->findOneBy(['name' => $country]);
        // Mira si existe dicho dato con dicho tipo.
        if ($foundCountry->getCountryData()->getDataType() == $type) return true;

        return false;
   
    }

    /**
     * Guarda datos de pais en la db
     */     
    public function createCountryData(array $json, String $type) : CountryData
    {
        /** 
        * @var DataCountryRepository 
        */
        $countryDataRepository = $this->getDoctrine()->getRepository(CountryData::class);

        $countryData = $countryDataRepository->createCountryData($json, $type);

        return $countryData;

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
