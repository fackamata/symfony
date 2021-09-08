<?php

namespace App\Controller;
use App\Entity\Contact;
use App\Entity\Person;

use Doctrine\ORM\EntityManagerInterface;
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
        //return new Response(content:'Hello world');

        $titre = 'Hello World';
        $text = 'Bonjour jaime lidée dêtre un texte';
        $list = [
            'un',
            'deux',
            'trois',
            'quatre'
        ];

        return $this->render('hello_world/index.html.twig', [
            'titre' => $titre,
            'text' => $text,
            'list' => $list,
        ]);

    }

    /**
     * @Route("/person", name="app_person")
     */
    public function personController(): Response 
    {
        $person = new Person();
        $person->id = 1;
        $person->firstname = 'Kevin';
        $person->name = 'Micu';
        $person->sanitaryPass = false;

        //dump($person);die; équivaut à
        dd($person);
    }

    /**
     * @Route("/add/contact", name="app_add_contact")
     */
    public function addContact(EntityManagerInterface $em): Response 
    {
        $contact = new Contact();
        $contact->setName('John');
        $contact->setFirstname('Goude');
        $contact->setSanitaryPass(true);
        $contact->setPassword("passBout");

        /* $contact = new Contact();
        $contact
        ->setFirstname('Claude')
        ->setName('Poulou')
        ->setSanitaryPass(true)
        ->setPassword('1234'); */

        dump($contact); // dump = var_dump en mieux
        
        $em->persist($contact); // pour préparer la requête et créer un id
        $em->flush(); // pour envoyer la requête
        // dump($contact); 
        
        dd($contact);

    }

    /**
     * @Route("/contacts", name="app_contact")
     */
    public function contacts(EntityManagerInterface $em): Response
    {
        $contacts = $em->getRepository(Contact::class)->findAll();
        
        dd($contacts);
    }
}