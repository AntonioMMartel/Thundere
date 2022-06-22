<?php
namespace App\Data\Api;
use Symfony\Component\HttpFoundation\Response;



class TomorrowioDataRetriever implements DataRetriever 
{
    public static function fetchData($input): string
    {
        return ''; //'[{"Weahter":"Siuuuuuuu"}]';
    }

}
