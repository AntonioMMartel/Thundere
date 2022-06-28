<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ODM\MongoDB\DocumentManager;
use MongoDB\BSON\Regex;

use App\Document\Country;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Data\Api\RestCountriesDataRetriever;
use App\Data\DataManager;
use App\Repository\CountryRepository;
use App\Data\Decorator\GeneralDataDecorator;

class CountryController extends AbstractController
{   
    /**
     * @Route("/data/country", name="country", methods="POST")
     */
    public function fetchCountryData(Request $request, DataManager $dataManager): Response
    {   
        $input = $request->toArray()['input'];
        $types = $request->toArray()['types'];

        $data = $dataManager->getData(["General", "Weather"], $input);

        return new Response(
            json_encode($data),
            Response::HTTP_OK,
            ['content-type' => 'application/json']
        );
    }

    
    /**
     * @Route("/country/{id}", name="update_country", methods="PUT")
     */
    public function updateCountry(CountryRepository $countryRepository, $id, Request $request, DocumentManager $documentManager): Response 
    {
        $foundCountry = $countryRepository->findOneBy(["_id" => $id]);

        if (!$foundCountry) {
            throw $this->createNotFoundException(sprintf(
                'No country found with id "%s"',
                $id
            ));
        }

        $data = $request->toArray();
        
        if (isset($data["Iso code"])) {
             $documentManager->createQueryBuilder(Country::class)
            ->findAndUpdate()
            ->field('_id')->equals($id)
            ->field('isoCode')->set($data["Iso code"])
            ->getQuery()
            ->execute();
        }

        if (isset($data["Names"])) {
            $documentManager->createQueryBuilder(Country::class)
            ->findAndUpdate()
            ->field('_id')->equals($id)
            ->field('names')->set($data["Names"])
            ->getQuery()
            ->execute();
        }

        // Country data.
        
        return new Response(
            Response::HTTP_OK
        );

    }

    /**
     * @Route("/country/{id}", name="delete_country", methods="DELETE")
     */
    public function deleteCountry(CountryRepository $countryRepository, $id): Response
    { 
        $countryRepository->deleteCountryById($id);
        return new Response('', 204);
    }

    /**
     * @Route("/country", name="add_country", methods="POST")
     */
    public function addCountry(RestCountriesDataRetriever $restCountriesDataRetriever, CountryRepository $countryRepository, Request $request, GeneralDataDecorator $generalDataDecorator): Response
    {   
        
        $data = $request->toArray();
        
        if(isset($data["Mode"])){
            if($data["Mode"] == "ADD_ALL"){
                $savedData = $this->addAllCountries($countryRepository, $restCountriesDataRetriever, $generalDataDecorator);
                return new Response(
                    $savedData,
                    Response::HTTP_OK,
                  ['content-type' => 'application/json']
                );
            }
        }

        $countryRepository->createCountry($data["Names"], $data["Iso Code"], [], "NO_DATA");

        return new Response(
            Response::HTTP_OK
        );
    }

    /**
     * @Route("/search/country/{input}", name="search_countries", methods="GET")
     */
    public function searchCountriesByName($input, DocumentManager $documentManager) {

        // Array de countries
        $countries = $documentManager->createQueryBuilder(Country::class)
        ->field('names')->equals(new Regex("^".$input, "im"))
        ->getQuery()
        ->execute()
        ->toArray();

        $names = [];
        foreach($countries as $country){
            $names += [$country->getCommonName() => $country->getFlag()];
        }

        return new Response(
            json_encode($names),
            Response::HTTP_OK,
            ['content-type' => 'application/json']
        );
    }

    private function addAllCountries(CountryRepository $countryRepository, RestCountriesDataRetriever $restCountriesDataRetriever, GeneralDataDecorator $generalDataDecorator){
        // String con todos los datos -> array de objetos
        $allData =json_decode($restCountriesDataRetriever->fetchAllData(), true);

        // Llamamos al decorador que me pone los datos generales:
        $savedData = $generalDataDecorator->saveAllData($allData);

        return new Response(
            Response::HTTP_OK,
        );
    }

}
