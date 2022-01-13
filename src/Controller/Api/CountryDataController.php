<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Data\DataManager;

class CountryDataController extends AbstractController
{   
    /**
     * @Route("/data/country", name="country_data", methods="POST")
     */
    public function fetchCountryData(Request $request, DataManager $dataManager): Response
    {   
        $input = $request->toArray()['input'];

        // $types se extraerá de la configuración del usuario. Por ahora: solo generales
        $types = array("General");

        $data = $dataManager->getData($types, $input);

        return new Response(
            json_encode($data),
            Response::HTTP_OK,
            ['content-type' => 'application/json']
        );
    }

}
