<?php
namespace Api\Data;


class CountryData 
{   
    protected Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getData(String $input): String
    {
        return "";
    }
}