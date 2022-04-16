<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\ODM\MongoDB\Types\Type as Type;
use Doctrine\Bundle\MongoDBBundle\Validator\Constraints\Unique as MongoDBUnique;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\Document(collection="users", db="Thundere", repositoryClass=\App\Repository\UserRepository::class)
 * @MongoDBUnique(fields="email")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    
    /**
     * @MongoDB\Id
     */
    private $id;
    
    /**
     * @MongoDB\Field(type="string")
    */
    private $email;

    /**
     * @MongoDB\Field(type="collection")
    */
    private $roles = [];

    /**
     * @MongoDB\Field(type="string")
    */
    private $password;

    /**
     * @MongoDB\Field(type="string")
    */
    private $name;

    /**
     * @MongoDB\Field(type="string")
    */
    private $confirmation_code;

    /**
     * @MongoDB\Field(type="date_immutable")
    */
    private $confirmation_time;

    /**
     * @MongoDB\Field(type="date_immutable")
    */
    private $created_time;

    public function __construct(){}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        //$roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getConfirmationCode(): ?string
    {
        return $this->confirmation_code;
    }

    public function setConfirmationCode(string $confirmation_code): self
    {
        $this->confirmation_code = $confirmation_code;

        return $this;
    }

    public function getConfirmationTime(): ?\DateTimeInterface
    {
        return $this->confirmation_time;
    }

    public function setConfirmationTime(\DateTimeInterface $confirmation_time): self
    {
        $this->confirmation_time = $confirmation_time;

        return $this;
    }

    public function getCreatedTime(): ?\DateTimeInterface
    {
        return $this->created_time;
    }

    public function setCreatedTime(\DateTimeInterface $created_time): self
    {
        $this->created_time = $created_time;

        return $this;
    }


}