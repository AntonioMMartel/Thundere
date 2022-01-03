<?php

namespace Api\Data;



use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Country;
use App\Entity\CountryData;

use Api\Data\Database as Database;


use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Clase que gestiona las apis y sus datos
 * https://refactoring.guru/es/design-patterns/decorator
 * Este es como el cocinero. Escoge que wraps cubriran a los datos
 * 
 * Faltará entonces determinar el dato y sus wraps.
 * 
 *  La idea es que cada wrap forme parte de un "tipo" o de varios tipos de dato
 * 
 */
class DataManager {

    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Llama a los decoradores de los tipos que queremos
    public function getData(array $types, String $input): String{


        return "";
    }

    public function countryDataExists(){
        return false;
    }

}