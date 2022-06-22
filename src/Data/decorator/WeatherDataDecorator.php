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

    }

    private function saveDataInDb(array $data, array $translations, String $iso): Country
    {   
        // Añade los datos en el este.
        // if (!$country = $this->database->addData($iso, $translations, $data, $this->type)) return null;
            
        return $country;
    }
}