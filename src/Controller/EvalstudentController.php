<?php

namespace App\Controller;

use App\Entity\Evalstudent;
use App\Form\EvalstudentType;
use App\Repository\EvalstudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/evalstudent")
 */
class EvalstudentController extends AbstractController
{
    /**
     * @Route("/{id}/edit", name="evalstudent_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Evalstudent $evalstudent): Response
    {
        if ($this->getUser() != $evalstudent->getEvaluation()->getClassroom()->getTeacher()) {
            $this->addFlash('danger', 'Cette évaluation ne vous est pas rattachée.');
            return $this->redirectToRoute('board');
        }

        $form = $this->createForm(EvalstudentType::class, $evalstudent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('evaluation_appreciation', array('id'=>$evalstudent->getEvaluation()->getId()));
        }

        return $this->render('evalstudent/edit.html.twig', [
            'evalstudent' => $evalstudent,
            'form' => $form->createView(),
        ]);
    }
}
