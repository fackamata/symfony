<?php

namespace App\Controller;

use App\Entity\Acteur;
use App\Entity\Realisateur;
use App\Entity\Film;
use App\Form\ActeurType;
use App\Form\FilmType;
use App\Form\RealisateurType;
use App\Kernel;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FilmController extends AbstractController
{
    /**
     * @Route("/film/acteur", name="film_acteur")
     */
    public function acteur(Request $request, EntityManagerInterface $em): Response
    {
        $acteur = new Acteur(); /* on le créer $acteur puis on le passe ds la fct createForm sinon ça le flush*/
        $form = $this->createForm(ActeurType::class, $acteur);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($acteur);
            $em->flush();

            return $this->redirectToRoute('film_acteur');
        }

        $entities = $em->getRepository(Acteur::class)->findAll();

        return $this->render('film/personne.html.twig', [
            'form' => $form->createView(),
            'entity_type' => 'Acteur', /* pour différencier dans la vue ce qu'on a créer */
            'entities'=> $entities,
        ]);
    }

    /**
     * @Route("/film/realisateur", name="film_realisateur")
     */
    public function realisateur(Request $request, EntityManagerInterface $em): Response
    {
        $realisateur = new Realisateur(); /* on le créer $Realisateur puis on le passe ds la fct createForm sinon ça le flush*/
        $form = $this->createForm(RealisateurType::class, $realisateur);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($realisateur);
            $em->flush();
            return $this->redirectToRoute('film_realisateur');
        }

        $entities = $em->getRepository(Realisateur::class)->findAll();

        return $this->render('film/personne.html.twig', [
            'form' => $form->createView(),
            'entity_type' => 'Realisateur', /* pour différencier dans la vue ce qu'on a créer */
            'entities'=> $entities,
        ]);
    }
    /**
     * @Route("/film", name="film_film")
     */
    public function film(Request $request, EntityManagerInterface $em): Response
    {
        $film = new Film(); /* on le créer $film puis on le passe ds la fct createForm sinon ça le flush*/
        $form = $this->createForm(FilmType::class, $film);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            /* getData retourne l'entité film */
            $film = $form->getData();

            /** @var UploadedFile $file */
            $file = $form->GET('file')->getData();
            
            $publicDir = $this->getParameter('kernel.project_dir').'/public';
            $fileDir = '/upload/film';
            $filename = $file->getClientOriginalName();

            $file->move($publicDir.$fileDir, $filename);
            $film->setImage($fileDir.'/'.$filename); // on veut /upload/film/image.jpg
            
            $em->persist($film);
            $em->flush();
            
            return $this->redirectToRoute('film_film');
        }
        
        $films = $em->getRepository(Film::class)->findAll();

        dump($films);


        return $this->render('film/index.html.twig', [
            'form' => $form->createView(),
            'films'=> $films,
        ]);
    }
}
