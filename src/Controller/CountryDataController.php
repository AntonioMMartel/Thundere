<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CountryDataController extends AbstractController
{   
    /**
     * Devuelve los datos de un país al front
     * @Route("/data/iso/", name="city_data")
     */
    public function fetchCountryData(String $input): Response
    {
        
        /** 
        * @var CountryRepository 
        */
        $countryRepository = $this->getDoctrine()->getRepository(Country::class);

        /** 
        * @var DataCountryRepository 
        */
        $countryDataRepository = $this->getDoctrine()->getRepository(CountryData::class);

        // Mira si existe en la db
        if ($countryRepository->findOneBy(['name' => $input])){
            // Mira si tiene todos los datos que se necesitan

            // Si no se tienen todos los datos que se necesitan se llama a las apis que faltan

        } else {
        
            // Si no existe llama a todas las apis y creamos los datos de dicho país

            $restCountriesRawData =json_decode(file_get_contents('https://restcountries.com/v3.1/name/'.$input), false);

            // Obtenemos todas las traducciones.
            $translations = $restCountriesRawData->translations;
            $officialTranslationsRaw = json_decode($restCountriesRawData->name);
            $officialTranslationsNatives = json_decode($officialTranslationsRaw->nativeName);
            $officialTranslations = '{"name": {
                                      "official":'.'"'.$officialTranslationsRaw->official.'",'.'
                                      "common":'.'"'.$officialTranslationsRaw->common.'"'.'
                                    },'.$officialTranslationsNatives.",".$translations."}";

            $tomorrowioData= "";

            // Aqui habrá que hacer un for o algo.
            $jsonCountryData = "{restCountries:".$restCountriesData."}";
            
            // Obtienes todos los nombres que tiene dicho pais en todos los idiomas posibles

            // Guardamos datos en la db
            $countryData = $countryDataRepository->createCountryData($jsonCountryData);

            // Registras nombres en la db
            // $countryNames = $countryRepository->createCountries($names, $iso, $countryData);


        }
        // Prepara los datos pal front
        return new Response("");
    }

    /**
     * Obtenemos el nombre de un país en multiples idiomas
     *  1. El código iso de dicho país
     *  2. Todos los nombres de ese país con ese código ISO 
     */
    public function getAllCountryNames(String $json): String
    {
        return $json;
    }
}
