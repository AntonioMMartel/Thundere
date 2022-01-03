<?php

namespace App\Controller\Api;



use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Country;
use App\Entity\CountryData;

use Api\Data\Database;

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
        $db = new Database();

        // Existe en la db?
        if ($db->countryExists($input)){
            return new Response(Response::HTTP_OK);
        } 
        else {
            // Existe en la api?

            // Busca datos de identificación del país
            // $api->manageCountryIdentificationData($input)

        }


        return new Response("");
    }

}
