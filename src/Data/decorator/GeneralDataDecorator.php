<?php
namespace App\Data;


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

    private array $apis = array(RestCountriesDataRetriever::class);

    public function getData(String $input): array
    {
        // Los cogemos de la db
        if (!$data = $this->fetchDataFromDb($input)) // Si no están los cogemos de la api
        {   
            $data = array();
            foreach ($this->apis as $api) {
                $data = array_merge($data, $this->fetchDataFromApi($input, $api));
            }
            
            $translations = $this->getCountryTranslations($data);
            $iso = $this->getCountryIso($data);

            // Guardamos los datos en la db
            $this->saveDataInDb($data, $translations, $iso);

        }

        return array_merge(parent::getData($input), $data);
    }


    private function fetchDataFromDb(String $input): array
    {
        if ($databaseData = $this->database->fetchCountryData($input, $this->type))
            return $databaseData;
        return null;
    }

    private function fetchDataFromApi(String $input, DataRetriever $api): array
    {

        $rawData = $api->fetchData($input);
        $data = json_decode($rawData, true);

        if (is_array($data)) {
            $data = array_pop($data);
        } 
        else // No se encuentra nada (API caida o no existe el país)
        {
            return new Response(
                "Ese país no existe.",
                Response::HTTP_BAD_REQUEST,
                ['content-type' => 'application/json']
            );
        }
        return $data;
    }

    private function getCountryTranslations(array $restCountriesData): array
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

    private function getCountryIso(array $restCountriesData)
    {
        // Obtenemos el código ISO. Usaremos alpha-2
        // Según iso.org: alpha-2 para uso general
        // alpha-3 se asemeja más al nombre del pais 
        // numeric-3 si no se usan caracteres del latin
        return $restCountriesData['cca2'];
    }

    private function saveDataInDb(array $data, array $names, String $iso): array
    {
        // Guardamos datos en la db
        // ES UNA LOCURA GUARDAR JSONs con datos desestructurados EN UNA DB RELACIONAL -> Por temas de denormalización
        // Para mi caso de uso no influye -> No se harán búsquedas en función de dichos datos.
        if (!$countryData = $this->data->db->createCountryData($data, $this->type)) 
            return null;

        // Registras nombres en la db y los vincula a dichos datos.
        if (!$countryNames = $this->data->db->createCountries($names, $iso, $data)) 
            return null;
            
        return array($countryData, $countryNames);
    }
}