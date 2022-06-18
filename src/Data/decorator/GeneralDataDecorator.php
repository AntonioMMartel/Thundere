<?php
namespace App\Data\Decorator;


use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Response;
use APp\Document\Country;
use App\Data\Api\RestCountriesDataRetriever;
use App\Data\Api\DataRetriever;
use App\Data\Api\TomorrowioDataRetriever;

/**
 * Obtiene datos generales del país.
 */
class GeneralDataDecorator extends DataDecorator
{
    /**
     * @var String Muestra el tipo de dato en la db
     */
    private String $type = "General";

    private array $apis = [RestCountriesDataRetriever::class];

    public function getData(String $input): array
    {   
        
        // Los cogemos de la db

        $data = $this->fetchDataFromDb($input);
        if (!$data) // Si no están los cogemos de la api
        {   
            
            $data = [];
            foreach ($this->apis as $api) {
                $data = array_merge($data, $this->fetchDataFromApi($input, $api));
            }
            
            $translations = $this->getCountryTranslations($data);
            $iso = $this->getCountryIso($data);

            // Guardamos los datos en la db
            $country = $this->saveDataInDb($data, $translations, $iso);
        }
        return array_merge(parent::getData($input), $data);
    }


    private function fetchDataFromDb(String $input): array
    {   
        $databaseData = $this->database->fetchCountryData($input, $this->type);
        //throw new BadRequestException(implode($databaseData));
        if ($databaseData){
            return $databaseData;
        }
           

        return [];
    }

    private function fetchDataFromApi(String $input, String $api): array
    {

        $rawData = $api::fetchData($input);
        $data = json_decode($rawData, true);

        if (is_array($data)) {
            $data = array_pop($data);
        } 
        else // No se encuentra nada (API caida o no existe el país)
        {
            return [];
        }
        return $data;
    }

    private function getCountryTranslations(array $restCountriesData): array
    {
        $names = [];

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

    // Los datos son un array de arrays. El primer elemento de los arrays más internos dice el tipo de datos que es.
    private function saveDataInDb(array $data, array $translations, String $iso): Country
    {   
        // Registras nombres en la db y los vincula a dichos datos.
        if (!$country = $this->database->createCountry($iso, $translations, $data, $this->type)) return null;
            
        return $country;
    }
}
