<?php

namespace App\Controller;

use App\Entity\Evaltheme;
use App\Entity\Evaluation;
use App\Form\EvalthemeType;
use App\Repository\EvalthemeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/app/evaltheme")
 */
class EvalthemeController extends AbstractController
{
    /**
     * @Route("/new/{id}", name="evaltheme_new", methods={"GET","POST"})
     */
    public function new(Request $request, Evaluation $evaluation): Response
    {
        if ($this->getUser() != $evaluation->getClassroom()->getTeacher()) {
            $this->addFlash('danger', 'Cette évaluation ne vous est pas rattachée.');
            return $this->redirectToRoute('board');
        }

        $evaltheme = new Evaltheme();
        $form = $this->createForm(EvalthemeType::class, $evaltheme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $evaltheme->setEvaluation($evaluation);
            $entityManager->persist($evaltheme);
            $entityManager->flush();

            return $this->redirectToRoute('evaluation_showarbo', array('id'=>$evaluation->getId()));
        }

        return $this->render('evaltheme/new.html.twig', [
            'evaluation' => $evaluation,
            'evaltheme' => $evaltheme,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="evaltheme_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Evaltheme $evaltheme): Response
    {
        if ($this->getUser() != $evaltheme->getEvaluation()->getClassroom()->getTeacher()) {
            $this->addFlash('danger', 'Cette évaluation ne vous est pas rattachée.');
            return $this->redirectToRoute('board');
        }
        $form = $this->createForm(EvalthemeType::class, $evaltheme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('evaluation_showarbo', array('id'=>$evaltheme->getEvaluation()->getId()));
        }

        return $this->render('evaltheme/edit.html.twig', [
            'evaltheme' => $evaltheme,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="evaltheme_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Evaltheme $evaltheme): Response
    {
        if ($this->getUser() != $evaltheme->getEvaluation()->getClassroom()->getTeacher()) {
            $this->addFlash('danger', 'Cette évaluation ne vous est pas rattachée.');
            return $this->redirectToRoute('board');
        }
        if ($this->isCsrfTokenValid('delete'.$evaltheme->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($evaltheme);
            $entityManager->flush();
        }

        return $this->redirectToRoute('evaluation_showarbo', array('id'=>$evaltheme->getEvaluation()->getId()));
    }
}
