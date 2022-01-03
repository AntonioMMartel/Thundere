<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CountryRepository::class)
 */
class Country
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
     * @ORM\Column(type="string", length=64)
     */
    private $isoCode;

    /**
     * @ORM\ManyToMany(targetEntity=CountryData::class, inversedBy="countries")
     */
    private $countryData;

    public function __construct()
    {
        $this->countryData = new ArrayCollection();
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

    public function getIsoCode(): ?string
    {
        return $this->isoCode;
    }

    public function setIsoCode(string $isoCode): self
    {
        $this->isoCode = $isoCode;

        return $this;
    }

    /**
     * @return Collection|countryData[]
     */
    public function getCountryData(): Collection
    {
        return $this->countryData;
    }

    public function addCountryData(countryData $countryData): self
    {
        if (!$this->countryData->contains($countryData)) {
            $this->countryData[] = $countryData;
        }

        return $this;
    }

    public function removeCountryData(countryData $countryData): self
    {
        $this->countryData->removeElement($countryData);

        return $this;
    }
}
