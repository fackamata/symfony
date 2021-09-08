<?php

namespace App\Controller;


use App\Entity\Contact;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact/list", name="contact_list")
     */
    public function index(EntityManagerInterface $em): Response
    {
        $contacts = $em->getRepository(Contact::class)->findAll();
        
        return $this->render('contact/index.html.twig', [
            'contacts' => $contacts,
        ]);
    }
    /**
     * @Route("/contact/detail/{id}", name="contact_detail")
     */
    public function detail(ContactRepository $contactRepo, $id): Response
    {
        $detail = $contactRepo->findOneById($id);
        
        return $this->render('contact/detail.html.twig', [
            'detail' => $detail,
        ]);
    }

//                      une façon plus courte de faire
//    /**
//      * @Route("/contact/detail/{id}", name="contact_detail")
//      */
//     public function detail(Contact $contact): Response
//     {
//         return $this->render('contact/detail.html.twig', [
//             'detail' => $contact,
//         ]);
//     }


    /**
     * @Route("/contact/add", name="contact_add")
     */
    public function add(Request $request, EntityManagerInterface $em): Response
    {        
        // post = request et get = query

        //permet de retrouver toute les variables de $_POST
        $params = $request->request->all();
        dump($params);
        // si le tableau $params n'est pas vide, des données ont été envoyées via le formulaire
        if(!empty($params)){
            $contact = new Contact();
            $contact->setName($params['name']);
            $contact->setFirstname($params['firstname']);
            $contact->setPassword($params['password']);

            $contact->setSanitaryPass( isset($params['sanitaryPass']));
       
            /* //permet de retrouver la valeur $_POST['name'] 
            $request->request->get('name');
            //permet de retrouver toute les variables de $_GET
            $request->query->all(); */

            $em->persist($contact); // pour préparer la requête et créer un id
            $em->flush(); // pour envoyer la requête

            return $this->redirectToRoute('contact_list'); // pour rediriger sur un page donné
         }
        return $this->render('contact/add.html.twig');
    }

    /**
//      * @Route("/contact/delete/{id}", name="contact_delete")
     */
    public function delete(Contact $contact, EntityManagerInterface $em): Response
    
    { 
        $em->remove($contact);
        $em->flush();
        return $this->redirectToRoute('contact_list'); // pour rediriger sur un page donné

    }
    
}
