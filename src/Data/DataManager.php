<?php

namespace App\Data;


use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

use App\Data\Database\Database;
use App\Data\Decorator\GeneralDataDecorator;
use App\Data\Decorator\DataDecorator;
use App\Repository\CountryRepository;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

/**
 * Clase que gestiona las apis y sus datos
 * https://refactoring.guru/es/design-patterns/decorator
 */
class DataManager {

    protected $documentManager;

    private array $decorators = ["General" => GeneralDataDecorator::class];

    public function __construct(DocumentManager $documentManager)
    {
        $this->documentManager = $documentManager;
    }
    
    // Llama a los decoradores de los tipos que queremos
    public function getData(array $types, String $input): array
    {
        $data = new Data();
        $database = new Database($this->documentManager);
        foreach ($types as $type){
            $data = new $this->decorators[$type]($data, $database) ?? null;
        }
        return $data->getData($input);
    }

}