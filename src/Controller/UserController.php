<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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

    /**
     * @Route("/user/{name}", name="userShowByname")
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
     * @Route("/user/make/{nombre}", name="createUser")
    */
    public function createUser($nombre, UserPasswordHasherInterface $passwordHasher): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = new User();
        $user->setName($nombre);
        $user->setEmail($nombre."@email.com");

        // Contraseña:
        $plaintextPassword = "meteoro";
        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $plaintextPassword
        );

        $user->setPassword($hashedPassword);

        $entityManager->persist($user);

        $entityManager->flush();

        return new Response('Saved new user with id '.$user->getId());
    }

}
