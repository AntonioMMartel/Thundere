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
    protected String $type = "General";

    protected array $apis = [RestCountriesDataRetriever::class];

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

    public function saveAllData($data) {
        foreach ($data as $countryData) {
            $country = $this->fetchDataFromDb($countryData["name"]["common"]);
            if (!$country){  // Si no están los ponemos de la api
                $translations = $this->getCountryTranslations($countryData);
                $iso = $this->getCountryIso($countryData);
                // Guardamos los datos en la db
                $country = $this->saveDataInDb($countryData, $translations, $iso);
            }
        }
        return $data;
    }

    private function getCountryTranslations(array $restCountriesData): array
    {
        $names = [];

        foreach ($restCountriesData['translations'] as $entry) {
            $names = array_merge($names, array_values($entry));
        }
        if(isset($restCountriesData['name']['common'])) 
            array_push($names, $restCountriesData['name']['common']);

        if(isset($restCountriesData['name']['official'])) 
            array_push($names, $restCountriesData['name']['official']);

        if(isset($restCountriesData['name']['nativeName'])) 
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
