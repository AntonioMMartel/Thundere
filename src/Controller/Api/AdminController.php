<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Document\Country;
use App\Document\User;
use App\Data\DataManager;
use App\Repository\CountryRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends AbstractController
{   
    /**
     * @Route("/admin/countries", name="get_all_countries", methods="GET")
     */
    public function getAllCountries(DocumentManager $documentManager): Response
    {   
        // Cursor para capturar datos
        $cursor = $documentManager
                  ->getDocumentCollection(Country::class)
                  ->find();

        return $this->json(['countries' => $cursor->toArray()]);
    }

    /**
     * @Route("/admin/users", name="get_all_users", methods="GET")
     */
    public function getAllUsers(DocumentManager $documentManager): Response
    {   
        // Cursor para capturar datos
        $cursor = $documentManager
                  ->getDocumentCollection(User::class)
                  ->find();

        return $this->json(['users' => $cursor->toArray()]);
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
     * @Route("/user/{id}", name="delete_user", methods="DELETE")
     */
    public function deleteUser(UserRepository $userRepository, $id): Response
    { 
        $result = $userRepository->deleteUserById($id);
        return $result ? new Response('', 204) : new Response('', 204) ;
    }


    /**
     * @Route("/country/{id}", name="update_country", methods="PUT")
     */
    public function updateCountry(CountryRepository $countryRepository, $id, Request $request): Response 
    {
        $foundCountry = $countryRepository->findOneBy(["_id" => $id]);

        if (!$foundCountry) {
            throw $this->createNotFoundException(sprintf(
                'No country found with id "%s"',
                $id
            ));
        }

        $data = json_decode($request->getContent(), true);

        throw $this->createNotFoundException(serialize($data));


    }

}
