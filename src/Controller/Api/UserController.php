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

    /**
     * @Route("/user/{id}", name="delete_user", methods="DELETE")
     */
    public function deleteUser(UserRepository $userRepository, $id): Response
    { 
        $result = $userRepository->deleteUserById($id);
        return $result ? new Response('', 204) : new Response('', 204) ;
    }

    
     /**
     * @Route("/user/{id}", name="update_user", methods="PUT")
     */
    public function updateUser(UserRepository $userRepository, 
                               Request $request, 
                               DocumentManager $documentManager,
                               $id, 
                               ): Response 
    {
        $founduser = $userRepository->findOneBy(["_id" => $id]);

        if (!$founduser) {
            throw $this->createNotFoundException(sprintf(
                'No user found with id "%s"',
                $id
            ));
        }

        $data = $request->toArray();
        /*
         Name: user.name,
                      Email: user.email,
                      Roles: user.roles,
                      'Confirmation time': longToDate(user.confirmation_time.$date.$numberLong),
                      'Creation time': longToDate(user.created_time.$date.$numberLong), */
        
        if (isset($data["Name"])) {
             $documentManager->createQueryBuilder(User::class)
            ->findAndUpdate()
            ->field('_id')->equals($id)
            ->field('name')->set($data["Name"])
            ->getQuery()
            ->execute();
        }

        if (isset($data["Roles"])) {
             $documentManager->createQueryBuilder(User::class)
            ->findAndUpdate()
            ->field('_id')->equals($id)
            ->field('roles')->set($data["Roles"])
            ->getQuery()
            ->execute();
        }

        // Se aplica el clientTimeOffset
        // Porque cuando yo pongo las 11 es la hora que me sale en mi pc
        // Pero la db va a asumir que son las 11 GMT 0
        // Por eso incluimos el offset (es en minutos)

        if (isset($data["Confirmation time"])) {
             $documentManager->createQueryBuilder(User::class)
            ->findAndUpdate()
            ->field('_id')->equals($id)
            ->field('confirmation_time')->set(
                strtotime(
                    \DateTime::createFromFormat('j/n/Y, G:i:s', $data["Confirmation time"])
                    ->format('j-n-Y G:i:s')
                ) + ($data["clientTimeOffset"]*60)
            )
            ->getQuery()
            ->execute();
        }

        if (isset($data["Creation time"])) {
             $documentManager->createQueryBuilder(User::class)
            ->findAndUpdate()
            ->field('_id')->equals($id)
            ->field('created_time')->set(
                strtotime(
                    \DateTime::createFromFormat('j/n/Y, G:i:s', $data["Creation time"])
                    ->format('j-n-Y G:i:s')
                ) + ($data["clientTimeOffset"]*60)
            )
            ->getQuery()
            ->execute();
        }
        
        return new Response(
            Response::HTTP_OK
        );

    }


}
