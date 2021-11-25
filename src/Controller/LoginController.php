<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\PdoSessionHandler;

use Symfony\Component\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

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
     * @Route("/login", name="login")
     */
    public function index(): Response
    {   
 
        return $this->render('login/index.html.twig', []);
    }

    /**
     * Returns the current user.
     *
     * @Route(
     *     "user",
     *     methods={"GET"}
     * )
     *
     * @Security("has_role('ROLE_USER')")
     *
     * @return Response
     */
    public function getUserAction(): Response
    {
        return new Response(
            $this->serializer->serialize(
                $this->getUser(),
                'json', array('groups' => array('default'))
            )
        );
    }
}
