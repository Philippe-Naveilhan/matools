<?php

namespace App\Controller;

use App\Entity\Evalbloc;
use App\Entity\Evalcategory;
use App\Form\EvalblocType;
use App\Repository\EvalblocRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/app/evalbloc")
 */
class EvalblocController extends AbstractController
{
    /**
     * @Route("/new/{category}", name="evalbloc_new", methods={"GET","POST"})
     */
    public function new(Request $request, Evalcategory $category): Response
    {
        if ($this->getUser() != $category->getTheme()->getEvaluation()->getClassroom()->getTeacher()) {
            $this->addFlash('danger', 'Cette évaluation ne vous est pas rattachée.');
            return $this->redirectToRoute('board');
        }
        $evalbloc = new Evalbloc();
        $form = $this->createForm(EvalblocType::class, $evalbloc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $evalbloc->setCategory($category);
            $entityManager->persist($evalbloc);
            $entityManager->flush();

            return $this->redirectToRoute('evaluation_showarbo', array('id'=>$category->getTheme()->getEvaluation()->getId()));
        }

        return $this->render('evalbloc/new.html.twig', [
            'evaluation' => $category->getTheme()->getEvaluation(),
            'evalbloc' => $evalbloc,
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new_empty/{category}", name="evalbloc_new_empty", methods={"GET","POST"})
     */
    public function new_empty(Request $request, Evalcategory $category): Response
    {
        if ($this->getUser() != $category->getTheme()->getEvaluation()->getClassroom()->getTeacher()) {
            $this->addFlash('danger', 'Cette évaluation ne vous est pas rattachée.');
            return $this->redirectToRoute('board');
        }
        $evalbloc = new Evalbloc();

        $entityManager = $this->getDoctrine()->getManager();
        $evalbloc->setCategory($category);
        $evalbloc->setName('empty');
        $entityManager->persist($evalbloc);
        $entityManager->flush();

        return $this->redirectToRoute('evaluation_showarbo', array('id'=>$category->getTheme()->getEvaluation()->getId()));
    }

    /**
     * @Route("/{id}/edit", name="evalbloc_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Evalbloc $evalbloc): Response
    {
        if ($this->getUser() != $evalbloc->getCategory()->getTheme()->getEvaluation()->getClassroom()->getTeacher()) {
            $this->addFlash('danger', 'Cette évaluation ne vous est pas rattachée.');
            return $this->redirectToRoute('board');
        }
        $form = $this->createForm(EvalblocType::class, $evalbloc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('evaluation_showarbo', array('id'=>$evalbloc->getCategory()->getTheme()->getEvaluation()->getId()));
        }

        return $this->render('evalbloc/edit.html.twig', [
            'evalbloc' => $evalbloc,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="evalbloc_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Evalbloc $evalbloc): Response
    {
        if ($this->getUser() != $evalbloc->getCategory()->getTheme()->getEvaluation()->getClassroom()->getTeacher()) {
            $this->addFlash('danger', 'Cette évaluation ne vous est pas rattachée.');
            return $this->redirectToRoute('board');
        }
        if ($this->isCsrfTokenValid('delete'.$evalbloc->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($evalbloc);
            $entityManager->flush();
        }

        return $this->redirectToRoute('evaluation_showarbo', array('id'=>$evalbloc->getCategory()->getTheme()->getEvaluation()->getId()));
    }
}
