<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


use App\Entity\User;

class UserController extends AbstractController
{
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
}
