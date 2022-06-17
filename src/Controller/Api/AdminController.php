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
     * @Route("/country", name="get_all_countries", methods="GET")
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
     * @Route("/user", name="get_all_users", methods="GET")
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
     * @Route("/country", name="add_country", methods="POST")
     */
    public function addCountry(DocumentManager $documentManager): Response
    {
        
    }


    
}
