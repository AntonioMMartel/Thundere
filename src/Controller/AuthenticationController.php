<?php


namespace App\Controller;

use App\Entity\User;
use App\Entity\UserToken;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException;
use Symfony\Component\Serializer\SerializerInterface;


class AuthenticationController extends AbstractController
{

    /**
     * @var UserPasswordHasherInterface
     */
    private $passwordEncoder;

    /***
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * AuthController constructor.
     *
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param SerializerInterface $serializer
     */
    public function __construct(UserPasswordHasherInterface $passwordEncoder, SerializerInterface $serializer)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->serializer = $serializer;
    }


    /**
     * Register a new user.
     *
     * @Route(
     *     "register",
     *     methods={"POST"}
     * )
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws \HttpRequestException
     */
    public function registerAction(Request $request): Response
    {
        // Aseguramos que se haya mandado todo
        $name = $request->get('name');
        $email = $request->get('email');
        $password = $request->get('password');

        if (null === $name) {
            throw new Response("Error, not all data was sent: a value is null", 418); // 418 -> Error soy una tetera (habra que cambiarlo xd)
        }

        if (null === $email) {
            throw new Response("Error, not all data was sent: a value is null", 418); // 418 -> Error soy una tetera (habra que cambiarlo xd)
        }

        if (null === $password) {
            throw new Response("Error, not all data was sent: a value is null", 418); // 418 -> Error soy una tetera (habra que cambiarlo xd)
        }

        // Miramos si esta repe

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
        $user = $userRepository->createUser($request->toArray(), $this->passwordEncoder);

        // Mandamos el usuario en una respuesta
        return new Response(
            $this->serializer->serialize(
                $user,
                'json', array('groups' => array('default'))
            )
        );
    }

    /**
     * Login a user.
     *
     * @Route(
     *     "login",
     *     methods={"POST"}
     * )
     *
     * @param Request $request
     *
     * @return JsonResponse|Response
     *
     * @throws \HttpRequestException
     * @throws \Exception
     */
    public function loginAction(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $userRepository = $this->getDoctrine()->getRepository(User::class);

        $email = $request->get('email');
        $password = $request->get('password');

        if (null === $email) {
            throw new Response("Error, not all data was sent: a value is null", 418); // 418 -> Error soy una tetera (habra que cambiarlo xd)
        }

        if (null === $password) {
            throw new Response("Error, not all data was sent: a value is null", 418); // 418 -> Error soy una tetera (habra que cambiarlo xd)
        }

        $user = $userRepository->findOneBy(['email' => $email]);

        if (null === $user || !$this->passwordEncoder->isPasswordValid($user, $password)) {
            throw new AuthenticationCredentialsNotFoundException();
        }

        $userToken = new UserToken($user);
        $entityManager->persist($userToken);
        $entityManager->flush();

        $now = new \DateTime();

        return new JsonResponse(
            [
                'token' => $userToken->getToken(),
                'expiresIn' => $userToken->getExpiresIn()->getTimestamp() - $now->getTimestamp()
            ]
        );
    }

}