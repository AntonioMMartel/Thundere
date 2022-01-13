<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\BrowserKit\Request;

class LoginController extends AbstractController
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @Route("/api/login", name="login")
     */
    public function index(AuthenticationUtils $authenticationUtils, Request $request): Response
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

    // El autenticador de forms de symfony hace el login automaticamente
}
