<?php
namespace App\Data\Api;

use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Response;


class RestCountriesDataRetriever implements DataRetriever 
{
    public static function fetchData($input): string
    {   
        
        return file_get_contents('https://restcountries.com/v3.1/name/'.$input);
    }

}
