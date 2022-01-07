<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Country;
use App\Entity\CountryData;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

use Symfony\Component\Mime\Message;

class CountrySearchController extends AbstractController
{   
    /**
     * Busca si un país existe. Lo usa / para buscar un país y luego redirigir a la página de ver país
     * 
     * @Route("/data/search", name="country_search")
     */
    public function fetchCountryData(Request $request): Response
    {   
        
        throw new BadRequestHttpException("Esa ciudad no existe");
   
        $input = $request->toArray()['input'];
        /** 
        * @var CountryRepository 
        */
        $countryRepository = $this->getDoctrine()->getRepository(Country::class);

        // Mira si existe en la db
        if ($foundCountry = $countryRepository->findOneBy(['name' => $input])){
            // Mira si tiene todos los datos que se necesitan. A lo mejor interesa tener una columna con las apis de datos recogidas.
            return new Response(Response::HTTP_OK);
            // Si no se tienen todos los datos que se necesitan se llama a las apis que faltan

        } else {
            
            // El data manager nos da los datos y punto
            // si hay algun error el mismo data manager lo gestiona.
            // dataManager->getCountryData($input, $type)

            // Llama al manager de datos y le manda un array de tipos de datos que se buscan
            // dataManager->getData(array(tipos), $input)



            /** 
            * @var DataCountryRepository 
            */
            $countryDataRepository = $this->getDoctrine()->getRepository(CountryData::class);
            
            // Si no existe preguntale a la api

            /* ----------------- Rest Countries -------------------------- */
            $restCountriesRawData = file_get_contents('https://restcountries.com/v3.1/name/'.$input);
            $restCountriesData = json_decode($restCountriesRawData, true);

            if (is_array($restCountriesData))
                $restCountriesData = array_pop($restCountriesData);
            else 
                return new Response( "Esa ciudad no existe.",
                    Response::HTTP_BAD_REQUEST,
                    ['content-type' => 'application/json']
                ); // No se encuentra nada (API caida o no existe la ciudad)
                
            // Obtenemos todas las traducciones.
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
}
