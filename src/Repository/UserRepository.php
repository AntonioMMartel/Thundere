<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Doctrine\Persistence\ManagerRegistry;
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
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface, UserLoaderInterface
{
    public function __construct(ManagerRegistry $registry)
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
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function loadUserByIdentifier(string $nameOrEmail): ?User
    {
        $entityManager = $this->getEntityManager();

        return $entityManager->createQuery(
                'SELECT user
                FROM App\Entity\User user
                WHERE user.email = :query
                OR u.name = :query'
            )
            ->setParameter('query', $nameOrEmail)
            ->getOneOrNullResult();
    }

    public function loadUserByUsername(string $nameOrEmail): ?User
    {
        return $this->loadUserByIdentifier($nameOrEmail);
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
        $entityManager = $this->getEntityManager();
        $entityManager->persist($user);
        $entityManager->flush(); 

        return $user;
    }



    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
