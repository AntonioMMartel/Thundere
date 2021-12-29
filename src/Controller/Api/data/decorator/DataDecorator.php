<?php

namespace App\Controller\Api;

abstract class DataDecorator implements DataInterface
{
    protected Data $data;
    protected DataRetriever $dataRetriever;

    public function __construct(Data $component, DataRetriever $dataRetriever)
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