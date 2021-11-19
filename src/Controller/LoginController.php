<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use Symfony\Component\HttpFoundation\Session\Storage\Handler\PdoSessionHandler;

class LoginController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function index(AuthenticationUtils $authenticationUtils): Response
    {   
        // get the login error if there is one
+       $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
+       $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/index.html.twig', [
            'last_username' => $lastUsername,
+           'error'         => $error,
        ]);
    }

    /**
     * @Route("/login/createSessionDb", name="createSession")
     */
    public function createSessionTable(PdoSessionHandler $sessionHandlerService): Response
    {
        try {
            $sessionHandlerService->createTable();
        } catch (\PDOException $exception) {
            // the table could not be created for some reason
        }
        // Ponte a intentar hacer que las sesiones funciones con sqlite.
        return new Response('Db creada con exito');
    }
}
