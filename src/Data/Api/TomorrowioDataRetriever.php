<?php
namespace App\Data\Api;
use Symfony\Component\HttpFoundation\Response;



class TomorrowioDataRetriever implements DataRetriever 
{
    public static function fetchData($location): string
    {
        $lat = $location[0];
        $long = $location[1];
        return file_get_contents('https://api.tomorrow.io/v4/timelines?location='.$lat.','.$long.'&fields=temperature,precipitationIntensity,precipitationType,windSpeed,windGust,windDirection,temperatureApparent,cloudCover,cloudBase,cloudCeiling,weatherCode&timesteps=1h&units=metric&apikey=AGyyAclsTgh2G43NjKDvGOeQmxCbejh3'); // https://api.tomorrow.io/v4/timelines
    }

}
