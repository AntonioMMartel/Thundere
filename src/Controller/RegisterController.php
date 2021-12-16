<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function index(): Response
    {
        return $this->render('register/index.html.twig', []);
    }

    /**
     * @Route("/register/user", name="registerUser")
     */
    public function registerUser(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {   
        // Aseguramos que se haya mandado todo
        $name = $request->get('name');
        $email = $request->get('email');
        $password = $request->get('password');

         /** 
         * Si no encuentras ningún método que hayas declarado en el repositorio pones esto de abajo y Symfony se enterará de que es
         * un objeto de tipo UserRepository
         * 
         * @var UserRepository 
         */
        $userRepository = $this->getDoctrine()->getRepository(User::class);

        if ($userRepository->findOneBy(['email' => $email])) {
            return new Response('This e-mail is already used !');
        }

        // Lo creamos
        $user = $userRepository->createUser($request->toArray(), $passwordHasher);

        return new Response("User ".$user->getName()." created succesfully");
    }

}
