<?php

namespace Api\Data;


abstract class DataDecorator implements DataInterface
{
    protected CountryData $data;
    protected DataRetriever $dataRetriever;

    public function __construct(CountryData $component, DataRetriever $dataRetriever)
    {
        $this->component = $component;
        $this->db = new Database();
        $this->dataRetriever = $dataRetriever;

    }

    public function getData(String $input): String
    {
        return $this->data->getData($input);
    }
}