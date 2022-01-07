<?php

namespace Api\Data;


abstract class DataDecorator implements DataInterface
{
    protected Data $data;
    protected Database $database;
    /**
     *  @var array Contiene las apis de datos de las que se extraen los datos.
     */
    private array $apis;

    public function __construct(Data $data, array $apis)
    {
        $this->data = $data;
        $this->database = new Database();
        $this->apis = $apis;
    }

    public function getData(String $input): array
    {
        return $this->data->getData($input);
    }
}