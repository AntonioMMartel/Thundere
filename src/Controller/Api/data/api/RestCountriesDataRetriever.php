<?php
use Symfony\Component\HttpFoundation\Response;
namespace Api\Data;

class RestCountriesDataRetriever implements DataRetriever 
{
    public function fetchData($input): string
    {
        return file_get_contents('https://restcountries.com/v3.1/name/'.$input);
    }

}