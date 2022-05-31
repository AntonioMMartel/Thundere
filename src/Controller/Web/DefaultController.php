<?php

namespace App\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class DefaultController extends AbstractController
{   

    /**
     * @Route("/{route}", name="default")
     */
    public function route(): Response
    {
        return $this->render('index.html.twig');
    }

    /**
     * @Route("/{route}/{route2}", name="default_GET")
     */
    public function route2(): Response
    {
        return $this->render('index.html.twig');
    }

    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render('index.html.twig');
    }
}

