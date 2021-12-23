<?php

namespace App\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/test", name="test")
     */
    public function index(): Response
    {   
        $out = new \stdClass();
        $out->title = "Probando...";
        $out->data = "Texto random de ejemplo";

        return $this->render('test/index.html.twig', [
            'prueba_out' => json_encode($out)
        ]);
    }
    /**
     * Prueba para comparar si dos arrays tienen las mismas claves
     * 
     * @Route("/test/arrayTest/", name="testArray")
     */
    public function arrayTest(): Response
    {   
        $arrayBien = ["1" => "33", "2" => 43, "3" => 22, "5"=> 43];
        $array = ["2" => 1, "1" => 2, "3"=>21, "5" => 213];
        $resultado = array_diff_key($arrayBien,$array);
        return new Response(!array_diff_key($arrayBien, $array) && !array_diff_key($array, $arrayBien) ? 'true' : 'false');
    }

     /**
     * @Route("/test/apis/restCountries/{name}", name="testRestCountries")
     */
    public function apiRestCountries(String $name): Response
    {
        $out = new \stdClass();
        $out->title = "Rest Countries API";
        

        // Funciona
        $out->data = file_get_contents('https://restcountries.com/v3.1/name/'.$name);

        // La estructura de las llamadas a las APIS va a ser:
        // Vue llama a endpoint de datos (pinta que con un get esta bn)
        // PHP busca en la bd
        //      Exito: Devuelvo dato
        //      No está: Llamo a API -> Guardo dato -> Devuelvo dato
        // PHP responde a peticion con los datos.

        return $this->render('test/index.html.twig', [
            'prueba_out' => json_encode($out)
        ]);
    }

     /**
     * @Route("/test/apis/tomorrowio", name="testTomorrowio")
     */
    public function apiTomorrowio(): Response
    {   
        $out = new \stdClass();
        $out->title = "Tomorrow.io API";
        $out->data = "E";



        return $this->render('test/index.html.twig', [
            'prueba_out' => json_encode($out)
        ]);
    }
    

}
