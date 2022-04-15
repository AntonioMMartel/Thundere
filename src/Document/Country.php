<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\ODM\MongoDB\Types\Type as Type;
use Doctrine\Bundle\MongoDBBundle\Validator\Constraints\Unique as MongoDBUnique;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\Document(collection="countries", db="Thundere", repositoryClass=CountryRepository::class))
 */
class Country {
    
    /**
     * @MongoDB\Id
     */
    private $id;

    public function __construct()
    {}

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }
}