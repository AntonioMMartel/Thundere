<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="user")
     */
    private $user_creates_comment;

    /**
     * @ORM\ManyToMany(targetEntity=City::class)
     */
    private $user_bookmarks_city;

    /**
     * @ORM\Column(type="text")
     */
    private $confirmation_code;

    /**
     * @ORM\Column(type="datetime")
     */
    private $confirmation_time;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_time;

    /**
     * @ORM\OneToMany(targetEntity=UserToken::class, mappedBy="user", orphanRemoval=true)
     */
    private $userTokens;

    public function __construct()
    {
        $this->user_creates_comment = new ArrayCollection();
        $this->user_bookmarks_city = new ArrayCollection();
        $this->userTokens = new ArrayCollection();
    }

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
        $roles[] = 'ROLE_USER';

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

    /**
     * @return Collection|Comment[]
     */
    public function getUserCreatesComment(): Collection
    {
        return $this->user_creates_comment;
    }

    public function addUserCreatesComment(Comment $userCreatesComment): self
    {
        if (!$this->user_creates_comment->contains($userCreatesComment)) {
            $this->user_creates_comment[] = $userCreatesComment;
            $userCreatesComment->setUser($this);
        }

        return $this;
    }

    public function removeUserCreatesComment(Comment $userCreatesComment): self
    {
        if ($this->user_creates_comment->removeElement($userCreatesComment)) {
            // set the owning side to null (unless already changed)
            if ($userCreatesComment->getUser() === $this) {
                $userCreatesComment->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|City[]
     */
    public function getUserBookmarksCity(): Collection
    {
        return $this->user_bookmarks_city;
    }

    public function addUserBookmarksCity(City $userBookmarksCity): self
    {
        if (!$this->user_bookmarks_city->contains($userBookmarksCity)) {
            $this->user_bookmarks_city[] = $userBookmarksCity;
        }

        return $this;
    }

    public function removeUserBookmarksCity(City $userBookmarksCity): self
    {
        $this->user_bookmarks_city->removeElement($userBookmarksCity);

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

    /**
     * @return Collection|UserToken[]
     */
    public function getUserTokens(): Collection
    {
        return $this->userTokens;
    }

    public function addUserToken(UserToken $userToken): self
    {
        if (!$this->userTokens->contains($userToken)) {
            $this->userTokens[] = $userToken;
            $userToken->setUser($this);
        }

        return $this;
    }

    public function removeUserToken(UserToken $userToken): self
    {
        if ($this->userTokens->removeElement($userToken)) {
            // set the owning side to null (unless already changed)
            if ($userToken->getUser() === $this) {
                $userToken->setUser(null);
            }
        }

        return $this;
    }
}
