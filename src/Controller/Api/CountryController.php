<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Data\DataManager;
use App\Repository\CountryRepository;

class CountryController extends AbstractController
{   
    /**
     * @Route("/data/country", name="country", methods="POST")
     */
    public function fetchCountryData(Request $request, DataManager $dataManager): Response
    {   
        $input = $request->toArray()['input'];

        // $types se extraerá de la configuración del usuario. Por ahora: solo generales
        $types = array("General");
        
        $data = $dataManager->getData($types, $input);

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
    public function addCountry(CountryRepository $countryRepository, Request $request): Response
    {   
 
        $data = $request->toArray();
        $countryRepository->createCountry($data["Names"], $data["Iso Code"], [], "NO_DATA");

        return new Response(
            Response::HTTP_OK
        );
    }

}
