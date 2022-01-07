<?php

namespace App\Controller\Api;



use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Country;
use App\Entity\CountryData;

use Api\Data\Database as Database;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;


class CountryDataController extends AbstractController
{   
    /**
     * Devuelve los datos de un país al front
     * Lo usa /country/{nombre_pais} para mostrar los datos
     * @Route("/data/country", name="country_data")
     */
    public function fetchCountryData(Request $request): Response
    {
        $input = $request->toArray()['input'];
        $database = new Database();

        // Existe?

        return new Response("");
    }

}
