<?php

namespace App\Controller\Api;

use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\HttpFoundation\Response;

/**
 * Obtiene datos generales del país.
 */
class GeneralDataDecorator extends DataDecorator
{
    /**
     * @var String Muestra el tipo de dato en la db
     */
    private String $type = "General";

    public function getData(String $input): string
    {
        // Los cogemos de la db
        if (true) {

        } 
        else // Si no están los cogemos de la api
        {
            $apiData = $this->fetchDataFromApi($input);

            $translations = $this->getCountryTranslations($apiData);
            $iso = $this->getCountryIso($apiData);

            // Guardamos los datos en la db
            $this->saveDataInDb($apiData, $translations, $iso);

        }

        return parent::getData($input);
    }


    private function fetchDataFromDb($input): void
    {
    }

    private function fetchDataFromApi($input): array
    {

        $rawData = $this->dataRetriever->fetchData($input);
        $data = json_decode($rawData, true);

        if (is_array($data)) {
            $data = array_pop($data);
        } else
        // No se encuentra nada (API caida o no existe la ciudad)
        {
            return new Response(
                "Ese país no existe.",
                Response::HTTP_BAD_REQUEST,
                ['content-type' => 'application/json']
            );
        }
        return $data;
    }

    private function getCountryTranslations($restCountriesData): array
    {
        $names = array();

        foreach ($restCountriesData['translations'] as $entry) {
            $names = array_merge($names, array_values($entry));
        }
        array_push($names, $restCountriesData['name']['common']);
        array_push($names, $restCountriesData['name']['official']);

        foreach ($restCountriesData['name']['nativeName'] as $entry) {
            $names = array_merge($names, array_values($entry));
        }

        // Quita los repes.
        return array_unique($names);
    }

    private function getCountryIso($restCountriesData)
    {
        // Obtenemos el código ISO. Usaremos alpha-2
        // Según iso.org: alpha-2 para uso general
        // alpha-3 se asemeja más al nombre del pais 
        // numeric-3 si no se usan caracteres del latin
        return $restCountriesData['cca2'];
    }

    private function saveDataInDb(array $data, array $names, String $iso): string
    {
        // Guardamos datos en la db
        // ES UNA LOCURA GUARDAR JSONs con datos desestructurados EN UNA DB RELACIONAL -> Por temas de denormalización
        // Para mi caso de uso no influye -> No se harán búsquedas en función de dichos datos.
        $countryData = $this->data->db->createCountryData($data, $this->type);

        // Registras nombres en la db y los vincula a dichos datos.
        $countryNames = $this->data->db->createCountries($names, $iso, $data);
        return "";
    }
}
