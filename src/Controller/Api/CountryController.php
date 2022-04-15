<?php

namespace App\Controller\Api;

use App\Document\Country;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CountryController extends AbstractController
{   
    // Document manager para trabajar con los documentos de mongo
    /**
     * @Route("/data/countryM", name="get_country", methods="GET")
     */
    public function index(DocumentManager $documentManager): Response
    {   
        // Cursor para capturar datos
        $cursor = $documentManager
                  ->getDocumentCollection(Country:: class)
                  ->find();

        return $this->json(['countries' => $cursor->toArray()]);
    }

    // Document manager para trabajar con los documentos de mongo
    /**
     * @Route("/data/countryM", name="new_country", methods="POST")
     */
    public function new(Request $request, DocumentManager $documentManager): Response
    {   
        $country = new Country($request->request->get('path'));
        $documentManager->persist($country);
        $documentManager->flush();

        return $this->json(['countries' => $country->getId()]);
    }
}
