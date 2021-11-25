<?php

namespace App\Controller;

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
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }
    /**
     * Prueba para comparar si dos arrays tienen las mismas claves
     * 
     * @Route("/test/arrayTest/", name="test")
     */
    public function arrayTest(): Response
    {   
        $arrayBien = ["1" => "33", "2" => 43, "3" => 22, "5"=> 43];
        $array = ["2" => 1, "1" => 2, "3"=>21, "5" => 213];
        $resultado = array_diff_key($arrayBien,$array);
        return new Response(!array_diff_key($arrayBien, $array) && !array_diff_key($array, $arrayBien) ? 'true' : 'false');
    }

}
