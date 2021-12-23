<?php

namespace App\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\BrowserKit\Request;

class DefaultController extends AbstractController
{   

    /**
     * @Route("/logout", name="default")
     */
    public function logout(): Response
    {
        return new Response();
    }
    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {   
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        // Las variables se pasaran al componente de vue que gestiona el login
        // Leete https://symfony.com/doc/current/security.html#form-login que hay vulnerabilidades
        // si haces esto mal xd
        // En symfony casts hay cosas de como hacer el login
        return $this->render('login/index.html.twig', 
        [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    /**
     * @Route("/{route}", name="default")
     */
    public function route(): Response
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

