<?php

namespace App\Controller;


use App\Entity\Acteur;
use App\Entity\Realisateur;
use App\Entity\Film;
use App\Form\ActeurType;
use App\Form\FilmType;
use App\Form\RealisateurType;
use App\Repository\FilmRepository;
use App\Service\FileService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class FilmController extends AbstractController
{
    /**
     * @Route("/film/acteur", name="film_acteur")
     */
    public function acteur(Request $request, EntityManagerInterface $em,  FileService $fileService): Response
    {
        $acteur = new Acteur(); /* on le créer $acteur puis on le passe ds la fct createForm sinon ça le flush*/
        $form = $this->createForm(ActeurType::class, $acteur);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            //getData retourne l'entitée Acteur
            $acteur = $form->getData();

            /** @var UploadedFile $file */
            $file = $form->get('file')->getData();

            $filename = $fileService->upload($file, $acteur); // param de upload, n'inporte quel entité
            $acteur->setImage($filename); //  /upload/acteur/image.jpg


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
    public function realisateur(Request $request, EntityManagerInterface $em, FileService $fileService): Response
    {
        $realisateur = new Realisateur(); /* on le créer $Realisateur puis on le passe ds la fct createForm sinon ça le flush*/
        $form = $this->createForm(RealisateurType::class, $realisateur);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            //getData retourne l'entitée Realisateur
            $realisateur = $form->getData();

            /** @var UploadedFile $file */
            $file = $form->get('file')->getData();

            $filename = $fileService->upload($file, $realisateur); // param de upload, n'inporte quel entité
            $realisateur->setImage($filename); //  /upload/realis$realisateur/image.jpg

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
    public function film(Request $request, EntityManagerInterface $em, FileService $fileService): Response
    {
        $film = new Film();
        $form = $this->createForm(FilmType::class, $film);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            //getData retourne l'entitée Film
            $film = $form->getData();

            /** @var UploadedFile $file */
            $file = $form->get('file')->getData();

            $filename = $fileService->upload($file, $film); // param de upload, n'inporte quel entité
            $film->setImage($filename); //  /upload/film/image.jpg

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

    /**
     * @Route("/film/search", name="film_search")
     */
    public function search(): Response
    {
        $form = $this->createFormBuilder()
            ->add('strSearch', TextType::class, [
                'label' => 'rechercher',
                'required' => false,
            ])
            ->add('dateDebut', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('dateFin', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('acteur', EntityType::class, [
            'class' => Acteur::class,
            'choice_label' => 'fullname', 
            'required' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'chercher'])
            ->getForm();

            return $this->render('film/film.html.twig', [
                'form' => $form->createView(),
            ]);
    }

    /**
     * @Route("/film/search/response", name="film_search_response")
     */
    public function searchResponse(Request $request, FilmRepository $filmRepository): Response
    {
        $form = $request->request->all();

        $films = $filmRepository->search($form['form']);

        /* retourne le code html de la vue */
        $view = $this->renderView('film/_search.html.twig', [
            'films' => $films,
        ]);

        /* retourne une JsonResponse */
        return $this->json([
            'view' => $view,
        ]);
    }

}
