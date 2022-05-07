<?php

namespace App\Document;

use App\Repository\CountryRepository;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\ODM\MongoDB\Types\Type as Type;
use Doctrine\Bundle\MongoDBBundle\Validator\Constraints\Unique as MongoDBUnique;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\Document(collection="countries", db="Thundere", repositoryClass=App\Repository\CountryRepository::class))
 */
class Country {
    /**
     * @MongoDB\Id
     */
    private $id;

    /**
     * @MongoDB\Field(type="string")
    */
    private $name;

    /**
     * @MongoDB\Field(type="string")
    */
    private $isoCode;

    /**
     * Es una coleccion de datos: {type: data} Dentro de data esta el campo dateFetched
     * type: tipo de datos // data: los datos // dateFetched: antiguedad de los datos
     * @MongoDB\Field(type="collection")
    */
    private $countryData;

    public function __construct(){
    }

    /**
     * @return mixed
     */
    public function getId() {
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
        return $this->countryData? $this->contryData : new ArrayCollection();
    }

    public function addCountryData(array $countryData, String $type): self
    {   
        // Miramos si ya hay datos asociados al tipo al que queremos escribir
        // AQUI FALTA: 
        // 1. array de timeouts de tipos
        // 2. Hacer que cuando los datos sean muy viejos (timeout superado) sean sobreescritos
        if (!$this->countryData->containsKey($type)) {
            $this->countryData->add($countryData);
        }

        return $this;
    }

    public function removeCountryData(array $countryData): self
    {
        $this->countryData->removeElement($countryData);

        return $this;
    }


}