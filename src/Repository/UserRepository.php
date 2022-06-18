<?php

namespace App\Repository;

use App\Document\User;
use Doctrine\Bundle\MongoDBBundle\ManagerRegistry as MongoDBBundleManagerRegistry;
use Doctrine\Bundle\MongoDBBundle\Repository\ServiceDocumentRepository;
use Doctrine\Bundle\MongoDBBundle\Repository\ServiceDocumentRepositoryInterface;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceDocumentRepository implements PasswordUpgraderInterface, UserLoaderInterface, ServiceDocumentRepositoryInterface
{
    public function __construct(MongoDBBundleManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);
        $this->_dm->persist($user);
        $this->_dm->flush();
    }

    public function loadUserByIdentifier(string $email): ?User
    {
        $documentManager = $this->getDocumentManager();

        return $documentManager->createQueryBuilder(user::class)
            ->field('email')->equals($email)
            ->getQuery()
            ->execute();
    }

    public function loadUserByUsername(string $email): ?User
    {
        return $this->loadUserByIdentifier($email);
    }
    /**
     * @return User
     * 
     * @Route("/user/create", name="createUser", methods={"POST"})
     */
    public function createUser(Array $data, UserPasswordHasherInterface $passwordHasher): User 
    {   /*
        // Array vacio
        if(!$data) return null;
        
        // Faltan o sobran datos
        // El orden no importa
        $filter = ["name" => "", "email" => "", "password" => ""];
        if (!array_diff_key($data, $filter) && !array_diff_key($filter, $data)) return null;
        */
        // Mira si existe
        if ($this->findOneBy(['email' => $data['email']])) {
            return null;
        }

        // Creamos objeto del usuario
        $user = new User();
        $user->setName($data['name']);
        $user->setEmail($data['email']);
        $roles[] = 'ROLE_USER';
        $user->setRoles(array_unique($roles));

        // Contraseña:
        $plaintextPassword = $data['password'];
        $hashedPassword = $passwordHasher->hashPassword($user, $plaintextPassword);
        $user->setPassword($hashedPassword);

        // Fecha creacion
        $date = new \DateTime('@'.strtotime('now'));
        $user->setCreatedTime($date);

        // Enviamos email de confirmación
        $user->setConfirmationTime($date);
        $user->setConfirmationCode("temp");

        // Creamos el usuario en la bd
        $documentManager = $this->getDocumentManager();
        $documentManager->persist($user);
        $documentManager->flush(); 

        return $user;
    }

    public function deleteUserById($id): bool {
        $dm = $this->getDocumentManager();

        $foundUser = $this->findOneBy(["_id" => $id]);

        if(!$foundUser) return false;

        $dm->remove($foundUser);
        $dm->flush();

        return true;
    }

}
