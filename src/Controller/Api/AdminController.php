<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Document\Country;
use App\Data\DataManager;

class AdminController extends AbstractController
{   
    /**
     * @Route("/admin/countries", name="get_all_countries", methods="GET")
     */
    public function index(DocumentManager $documentManager): Response
    {   
        // Cursor para capturar datos
        $cursor = $documentManager
                  ->getDocumentCollection(Country::class)
                  ->find();

        return $this->json(['countries' => $cursor->toArray()]);
    }

}
