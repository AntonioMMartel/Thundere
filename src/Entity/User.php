<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=City::class, inversedBy="users")
     */
    private $user_favs_city;

    public function __construct()
    {
        $this->user_favs_city = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection|City[]
     */
    public function getUserFavsCity(): Collection
    {
        return $this->user_favs_city;
    }

    public function addUserFavsCity(City $userFavsCity): self
    {
        if (!$this->user_favs_city->contains($userFavsCity)) {
            $this->user_favs_city[] = $userFavsCity;
        }

        return $this;
    }

    public function removeUserFavsCity(City $userFavsCity): self
    {
        $this->user_favs_city->removeElement($userFavsCity);

        return $this;
    }
}
