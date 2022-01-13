<?php
namespace App\Data\Api;


interface DataRetriever
{
    public static function fetchData($input): String;
}