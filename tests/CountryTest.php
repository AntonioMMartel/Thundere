<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

// Antes de esto necesito tener MongoDb

class CountryTest extends KernelTestCase {
    /*
    private $entityManager;

    protected function setUp(): void {
        $kernel = self::bootKernel();

        DatabasePrimer::prime($kernel);

        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
    }

    public function testItWorks() {
        $this->assertTrue(true);
    }

    public function a_country_Data_record_can_be_created_in_the_db(){

        $countryData = new CountryData();
        $countryData->setJsonData("{'Pru':'Funciona'}");
        $countryData->setDataType("Prueba");
        $countryData->setCreatedAt(new \DateTimeImmutable('@'.strtotime('now')));
        
        $this->entityManager->persist($countryData);
        $this->entityManager->flush(); 

        $countryRepository = $this->entityManager->getRepository(Country::class);

        $countryRecord = $countryRepository->findOneBy("")
    }
    */
}