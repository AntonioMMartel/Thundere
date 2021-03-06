<?php

namespace App\Document;

use App\Repository\CountryRepository;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\ODM\MongoDB\Types\Type as Type;
use Doctrine\Bundle\MongoDBBundle\Validator\Constraints\Unique as MongoDBUnique;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
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
     * @MongoDB\Field(type="collection")
    */
    private $names;

    /**
     * @MongoDB\Field(type="string")
    */
    private $isoCode;

    /**
     * Es una coleccion de datos: {type: data} Dentro de data esta el campo dateFetched
     * type: tipo de datos // data: los datos // dateFetched: antiguedad de los datos
     * @MongoDB\Field(type="hash")
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

    public function getNames(): array
    {
        return $this->names;
    }

    public function setNames(array $names): self
    {
        $this->names = $names;

        return $this;
    }

    public function addName(string $name): void
    {
        $this->names += [$name];
    }

    public function addNames(array $names): void
    {
        $this->names += $names;
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

    public function getCountryData()
    {
        return $this->countryData;
    }

    public function getCommonName()
    {
        return $this->countryData["General"]["name"]["common"];
    }

    public function addCountryData(array $countryData, String $type): self
    {   
        // Miramos si ya hay datos asociados al tipo al que queremos escribir
        // AQUI FALTA: 
        // 1. array de timeouts de tipos
        // 2. Hacer que cuando los datos sean muy viejos (timeout superado) sean sobreescritos
        
        // Si no hay array de datos
        if(!$this->countryData && $type=="NO_DATA") $this->countryData=[]; 
          
        if($type=="NO_DATA") return $this;
        
        // Si no est?? ese dato en el array de datos
        if (!isset($this->countryData)) { 
            $this->countryData = [$type => $countryData]; 
        } else if (!isset($this->countryData[$type])) {
            $this->countryData += [$type => $countryData]; 
        } else if(isset($this->countryData["Weather"]) && $type=="Weather") {
            $this->countryData[$type] = $countryData;
        }
        // Si ya hab??an datos
        else {
            // Si estan anticuados se sobreescriben
            // (Esto deberia de verlo el DataManager)
            // Si no estaban de antes se a??aden
            array_merge($this->countryData[$type], $countryData);
        }


        return $this;
    }

    public function removeCountryData(array $countryData): self
    {
        $this->countryData->removeElement($countryData);

        return $this;
    }

    public function getFlag() {
        return $this->countryData["General"]["flags"]["png"];
    }

}