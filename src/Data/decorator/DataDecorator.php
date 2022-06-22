<?php

namespace App\Data\Decorator;

use App\Data\Data;
use App\Data\Database\Database;
use App\Data\DataInterface;


abstract class DataDecorator implements DataInterface
{
    protected Data $data;
    protected Database $database;
    protected String $type;
    /**
     *  @var array Contiene las apis de datos de las que se extraen los datos.
     */
    protected array $apis;

    public function __construct(Data $data, Database $database)
    {
        $this->data = $data;
        $this->database = $database;
    }

    public function getData(String $input): array
    {
        return $this->data->getData($input);
    }

    protected function fetchDataFromDb(String $input): array
    {   
        $databaseData = $this->database->fetchCountryData($input, $this->type);
        //throw new BadRequestException(implode($databaseData));
        if ($databaseData){
            return $databaseData;
        }
        return [];
    }

    protected function fetchDataFromApi(String $input, String $api): array
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
}