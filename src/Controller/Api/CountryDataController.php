<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Country;
use App\Entity\CountryData;


use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;


class CountryDataController extends AbstractController
{   
    /**
     * Devuelve los datos de un país al front
     * @Route("/data/country", name="country_data")
     */
    public function fetchCountryData(Request $request): Response
    {
        $input = $request->toArray()['input'];
        /** 
        * @var CountryRepository 
        */
        $countryRepository = $this->getDoctrine()->getRepository(Country::class);

        /** 
        * @var DataCountryRepository 
        */
        $countryDataRepository = $this->getDoctrine()->getRepository(CountryData::class);

        // Mira si existe en la db
        if ($foundCountry = $countryRepository->findOneBy(['name' => $input])){
            // Mira si tiene todos los datos que se necesitan. A lo mejor interesa tener una columna con las apis de datos recogidas.
            
            return new Response(
                json_encode($foundCountry->getCountryData()->getJsonData()),
                Response::HTTP_OK,
                ['content-type' => 'application/json']
            );
            // Si no se tienen todos los datos que se necesitan se llama a las apis que faltan

        } else {
        
            // Si no existe llama a todas las apis y creamos los datos de dicho país

            /* ----------------- Rest Countries -------------------------- */
            $restCountriesRawData = file_get_contents('https://restcountries.com/v3.1/name/'.$input);
            $restCountriesData = json_decode($restCountriesRawData, true);
            if(is_null($restCountriesData)) return null; // No se encuentra nada (API caida)
            if(is_array($restCountriesData)) { // Si no llega un array ha fallado
                $restCountriesData = array_pop($restCountriesData);
            } else {
                return $restCountriesData->message;
            }
            
            // Obtenemos todas las traducciones.
            // Array (Mucho más eficiente que con json)
            $names = array();
            
            foreach ($restCountriesData['translations'] as $entry) {
                $names= array_merge($names, array_values($entry));
            } 
            array_push($names, $restCountriesData['name']['common']);
            array_push($names, $restCountriesData['name']['official']);

            foreach ($restCountriesData['name']['nativeName'] as $entry) {
                $names= array_merge($names, array_values($entry));
            } 

            // Quita los repes.
            $names = array_unique($names);

            // Obtenemos el código ISO. Usaremos alpha-2
            // Según iso.org: alpha-2 para uso general
            // alpha-3 se asemeja más al nombre del pais 
            // numeric-3 si no se usan caracteres del latin
            $iso = $restCountriesData['cca2'];

            /* ----------------- Tomorrowio -------------------------- */
            $tomorrowioData= "";

            /* -------------------- Unificamos todos los datos de las apis ------------------------*/
            $arrayCountryData = $restCountriesData;
            
            // Guardamos datos en la db
            // ES UNA LOCURA GUARDAR JSONs con datos desestructurados EN UNA DB RELACIONAL -> Por temas de denormalización
            // Para mi caso de uso no influye -> No se harán búsquedas en función de dichos datos.
            $countryData = $countryDataRepository->createCountryData($arrayCountryData);

            // Registras nombres en la db y los vincula a dichos datos.
            $countryNames = $countryRepository->createCountries($names, $iso, $countryData);


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
