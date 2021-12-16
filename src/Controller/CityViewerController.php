<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CityViewerController extends AbstractController
{
    /**
     * @Route("/city/{name}", name="city_viewer")
     */
    public function index(): Response
    {   
        return $this->render('city_viewer/index.html.twig', [
        ]);
    }
}
