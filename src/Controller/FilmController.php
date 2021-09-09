<?php

namespace App\Controller;

use App\Entity\Acteur;
use App\Entity\Realisateur;
use App\Form\ActeurType;
use App\Form\RealisateurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
        }

        $entities = $em->getRepository(Realisateur::class)->findAll();

        return $this->render('film/personne.html.twig', [
            'form' => $form->createView(),
            'entity_type' => 'Realisateur', /* pour différencier dans la vue ce qu'on a créer */
            'entities'=> $entities,
        ]);
    }
}
