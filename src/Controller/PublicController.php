<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PublicController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(): Response
    {
        return $this->render('public/index.html.twig');
    }
    /**
     * @Route("/make/admin", name="make_admin")
     */
    public function makeAdmin(EntityManagerInterface $em): Response
    {
        $user = $this->getUser();

        if(!$user){
            // demander de se connecter
            $this->addFlash('error', 'Veuillez vous connecter'); // pour mettre des messages flash
            //redirect sur home
            return $this->redirectToRoute('app_login');
        }
        // ajout du role dans l'entité $user
        $user->addRoles('ROLE_ADMIN');
        // sauvegarde
        $em->flush();
        // redirect sur home
        return $this->redirectToRoute('film_film');
    }
}
