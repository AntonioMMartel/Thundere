<?php

namespace App\Data\Decorator;

use App\Data\Data;
use App\Data\Database\Database;
use App\Data\DataInterface;


abstract class DataDecorator implements DataInterface
{
    protected Data $data;
    protected Database $database;
    /**
     *  @var array Contiene las apis de datos de las que se extraen los datos.
     */
    private array $apis;

    public function __construct(Data $data, Database $database)
    {
        $this->data = $data;
        $this->database = $database;
    }

    public function getData(String $input): array
    {
        return $this->data->getData($input);
    }
}