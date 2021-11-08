<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\User;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index(): Response
    {   
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    private function createUser($nombre): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = new User();
        $user->setName($nombre);

        $entityManager->persist($user);

        $entityManager->flush();

        return new Response('Saved new product with id '.$user->getId());
    }

}
