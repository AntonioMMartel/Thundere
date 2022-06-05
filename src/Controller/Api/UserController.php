<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{

    /**
     * @Route("/register/user", name="registerUser", methods="POST")
     */
    public function registerUser(Request $request, UserPasswordHasherInterface $passwordHasher, UserRepository $userRepository): Response
    {   
        // Aseguramos que se haya mandado todo
        $name = $request->get('name');
        $email = $request->get('email');
        $password = $request->get('password');

        // Lo creamos
        $user = $userRepository->createUser($request->toArray(), $passwordHasher);
        if(!$user) throw new BadRequestHttpException('This e-mail is already used!', null, 400);

        return new Response("User ".$user->getName()." created succesfully");
    }

}
