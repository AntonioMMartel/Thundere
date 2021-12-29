<?php
namespace App\Controller\Api;

interface DataRetriever
{
    public function fetchData($input): String;
}