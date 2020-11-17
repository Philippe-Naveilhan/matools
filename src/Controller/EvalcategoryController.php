<?php

namespace App\Controller;

use App\Entity\Evalcategory;
use App\Form\EvalcategoryType;
use App\Repository\EvalcategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/evalcategory")
 */
class EvalcategoryController extends AbstractController
{
    /**
     * @Route("/", name="evalcategory_index", methods={"GET"})
     */
    public function index(EvalcategoryRepository $evalcategoryRepository): Response
    {
        return $this->render('evalcategory/index.html.twig', [
            'evalcategories' => $evalcategoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="evalcategory_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $evalcategory = new Evalcategory();
        $form = $this->createForm(EvalcategoryType::class, $evalcategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($evalcategory);
            $entityManager->flush();

            return $this->redirectToRoute('evalcategory_index');
        }

        return $this->render('evalcategory/new.html.twig', [
            'evalcategory' => $evalcategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="evalcategory_show", methods={"GET"})
     */
    public function show(Evalcategory $evalcategory): Response
    {
        return $this->render('evalcategory/show.html.twig', [
            'evalcategory' => $evalcategory,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="evalcategory_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Evalcategory $evalcategory): Response
    {
        $form = $this->createForm(EvalcategoryType::class, $evalcategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('evalcategory_index');
        }

        return $this->render('evalcategory/edit.html.twig', [
            'evalcategory' => $evalcategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="evalcategory_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Evalcategory $evalcategory): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evalcategory->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($evalcategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('evalcategory_index');
    }
}
