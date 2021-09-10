<?php

namespace App\Service;

use App\Interfaces\FilableInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileService
{
    private $projectDir;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->projectDir = $parameterBag->get('kernel.project_dir');
    }


    /* & devant un string envoie l'adresse mémoire
        car un string est envoyer directement en parametre
        mais un objet ou un array n'envoie que l'adresse mémoire
    */
    public function upload(UploadedFile $file, FilableInterface $entity): string
    {
        $publicDir = $this->projectDir . '/public';
        $fileDir   = $entity->getFileDirectory(); // créer un dossier pour chaque entité
        $filename  = $file->getClientOriginalName();

        $file->move($publicDir.$fileDir, $filename);

        return $fileDir.'/'.$filename;
    }
}