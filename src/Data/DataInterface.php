<?php
namespace App\Data;


/**
 * La operación getData() es manejada por los Decorators
 */
interface DataInterface
{
    public function getData(String $input): array;
}