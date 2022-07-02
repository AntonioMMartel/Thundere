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
        $tomorrow = date("Y-m-d", strtotime(" +1 days", time()));

        if (!$data || !isset($data[$tomorrow]) || !isset($data[$tomorrow][date("H").":00:00"] )  ) // Si no están los cogemos de la api
        {    
            // Get lat,long pair for coordinates
            $position = $this->database->getCountryPosition($input);
            $data = [];
            foreach ($this->apis as $api) {
                $data = array_merge($data, $this->fetchDataFromApi($position, $api));
            }

            $parsedData = [];

            // Organizas los datos
            foreach ($data["timelines"][0]["intervals"] as $timeInterval) {
                // $parsedData[substr($timeInterval["startTime"], 0, 11)] = año-dia-mesT
                // Si no esta esa fecha añadida la añadimos
                if(!isset($parsedData[substr($timeInterval["startTime"], 0, 10)])) {
                    // Añadimos esa fecha
                    $parsedData += [substr($timeInterval["startTime"], 0, 10) => []];
                }
                // Si no estan los datos de la hora dentro del dia añadidos los añadimos
                if(!isset($parsedData[substr($timeInterval["startTime"], 0, 10)][substr(substr($timeInterval["startTime"], 11, 19), 0, 8)])) {
                    // Añadimos a dicha fecha la hora y los datos meteorológicos dentro de la misma.
                    $parsedData[substr($timeInterval["startTime"], 0, 10)] += [substr(substr($timeInterval["startTime"], 11, 19), 0, 8) => $timeInterval["values"]];
                }
            }
            // Guardamos los datos en la db
            $country = $this->saveDataInDb($parsedData, $input);
        }
        return array_merge(parent::getData($input), ["Weather" => $data]);
    }

    private function saveDataInDb(array $data, String $input): Country
    {   
        if (!$country = $this->database->addData($input, $data, $this->type)) return null;
        return $country;
    }
}