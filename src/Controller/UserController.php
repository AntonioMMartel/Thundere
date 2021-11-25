<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


use App\Repository\UserRepository;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Session\Session;

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

    /**
     * @Route("/user/login/{name}", name="userShowByname")
    */
    public function showByName(String $name): Response
    {   
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findBy(array('name' => $name));

        if (!$users) {
            throw $this->createNotFoundException(
                'No users found for name: '.$name
            );
        }

        $response = "Users found:<ul>";
        foreach($users as $user) {
            $response = $response."<li> Nombre: ".$user->getName()."</li><ul>".
                                   "<li> Email: ".$user->getEmail()."</li>";
        }

        return new Response($response."</ul>");
    }

    /**
     * Debil a: CSFR attacks
     * @Route("/user/login", name="userLogin")
    */
    public function login(Request $request, UserRepository $userRepository){

        // Request con email y contraseña
        $data = $request->toArray();

        // Me pillas de doctrine al usuario
        $user = $userRepository->loadUserByIdentifier($data['email']);

        /*
        // Lo comparas
        if($passwordHasher->isPasswordValid($user, $data['password'])){
            return new Response("Todo crema");
        }
        */
        
        /*
        // Devuelves token
        $session = new Session();
        $session -> start();
        */
    }


}
