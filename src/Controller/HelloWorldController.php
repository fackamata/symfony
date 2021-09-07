<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloWorldController extends AbstractController
{
    /**
     * @Route("/hello/world", name="hello_world")
     */
    public function index(): Response
    {
        $vars = ["uno", "due","tree"];
        $texte = "un texte";
        // return new Response('Hello world');
        return $this->render('hello_world/index.html.twig', [
            'titre' => 'HelloWorldTitle',
            'vars'=> $vars,
            'text'=>$texte,
        ]);
    }

    
}
