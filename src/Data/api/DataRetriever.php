<?php
namespace Api\Data;


interface DataRetriever
{
    public function fetchData($input): String;
}