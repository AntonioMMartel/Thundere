<?php
namespace App\Controller\Api;


class Data implements DataInterface
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