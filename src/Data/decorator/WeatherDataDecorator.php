<?php
namespace App\Data\Decorator;

use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Response;
use APp\Document\Country;
use App\Data\Api\RestCountriesDataRetriever;
use App\Data\Api\TomorrowioDataRetriever;



use App\Data\Api\DataRetriever;

/**
 * Obtiene datos generales del país.
 */
class WeatherDataDecorator extends DataDecorator
{
    /**
     * @var String Muestra el tipo de dato en la db
     */
    protected String $type = "Weather";

    protected array $apis = [TomorrowioDataRetriever::class];

    public function getData(String $input): array 
    {   
        $data = $this->fetchDataFromDb($input);
        if (!isset($data["Weather"])) // Si no están los cogemos de la api
        {    
            // Get lat,long pair for coordinates
            $position = $this->database->getCountryPosition($input);

            $data = [];
            foreach ($this->apis as $api) {
                $data = array_merge($data, $this->fetchDataFromApi($position, $api));
            }

            // Guardamos los datos en la db
            $country = $this->saveDataInDb($data, $input);
        }
        return array_merge(parent::getData($input), $data);
    }

    private function saveDataInDb(array $data, String $input): Country
    {   
        if (!$country = $this->database->addData($input, $data, $this->type)) return null;
        return $country;
    }
}