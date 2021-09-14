<?php

namespace App\Controller;

use App\Entity\Page;
use App\Form\PageType;
use App\Service\FileService;
use App\Repository\PageRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/page")
 */
class PageController extends AbstractController
{
    /**
     * @Route("/", name="page_index", methods={"GET"})
     */
    public function index(PageRepository $pageRepository): Response
    {
        return $this->render('page/index.html.twig', [
            'pages' => $pageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="page_new", methods={"GET","POST"})
     */
    public function new(Request $request, FileService $fileService): Response
    {
        $page = new Page();
        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();

            //getData retourne l'entitée Acteur
            $page = $form->getData();

            /** @var UploadedFile $file */
            $file = $form->get('file')->getData();

            $filename = $fileService->upload($file, $page); // param de upload, n'inporte quel entité
            $page->setImage($filename); //  /upload/page/image.jpg


            $entityManager->persist($page);
            $entityManager->flush();

            return $this->redirectToRoute('page_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('page/new.html.twig', [
            'page' => $page,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="page_show", methods={"GET"})
     */
    public function show(Page $page): Response
    {
        return $this->render('page/show.html.twig', [
            'page' => $page,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="page_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Page $page): Response
    {
        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('page_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('page/edit.html.twig', [
            'page' => $page,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="page_delete", methods={"POST"})
     */
    public function delete(Request $request, Page $page): Response
    {
        if ($this->isCsrfTokenValid('delete'.$page->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($page);
            $entityManager->flush();
        }

        return $this->redirectToRoute('page_index', [], Response::HTTP_SEE_OTHER);
    }
}