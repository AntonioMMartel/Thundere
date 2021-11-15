<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/user/create", name="createUser", methods={"POST"})
     * 
    */
    public function createUser(Request $request,  UserPasswordHasherInterface $passwordHasher): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $data = $request->toArray();

        $user = new User();
        $user->setName($data['name']);
        $user->setEmail($data['email']);
        // Contraseña:
        $plaintextPassword = $data['password'];
        $hashedPassword = $passwordHasher->hashPassword($user, $plaintextPassword);

        $user->setPassword($hashedPassword);
        $entityManager->persist($user);
        $entityManager->flush(); 

        return new Response('Saved new user with email '.$user->getEmail());
    }

}
