<?php

namespace App\Controller;

use App\Entity\Competencestudent;
use App\Entity\Evalbloc;
use App\Entity\Evalcompetence;
use App\Entity\Evaluation;
use App\Form\EvalcompetenceType;
use App\Repository\EvalcompetenceRepository;
use App\Repository\EvalstudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/app/evalcompetence")
 */
class EvalcompetenceController extends AbstractController
{
    /**
     * @Route("/new/{bloc}", name="evalcompetence_new", methods={"GET","POST"})
     */
    public function new(Request $request,
                        Evalbloc $bloc,
                        EvalstudentRepository $evalstudentRepository
    ): Response
    {
        if ($this->getUser() != $bloc->getCategory()->getTheme()->getEvaluation()->getClassroom()->getTeacher()) {
            $this->addFlash('danger', 'Cette évaluation ne vous est pas rattachée.');
            return $this->redirectToRoute('board');
        }
        $evaluation = $bloc->getCategory()->getTheme()->getEvaluation();
        $evalcompetence = new Evalcompetence();
        $form = $this->createForm(EvalcompetenceType::class, $evalcompetence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $competences = $bloc->getEvalcompetences();
            $placeorder = count($competences) + 1;
            $entityManager = $this->getDoctrine()->getManager();
            $evalcompetence->setBloc($bloc);
            $evalcompetence->setPlaceorder($placeorder);
            $evalcompetence->setEvaluation($evaluation);
            $evalcompetence->setCompletion('empty');
            $entityManager->persist($evalcompetence);
            $entityManager->flush();

            foreach($evalstudentRepository->findBy(['evaluation'=>$evaluation]) as $evalstudent){
                $entityManager = $this->getDoctrine()->getManager();
                $competencestudent = new Competencestudent();
                $competencestudent->setEvalstudent($evalstudent);
                $competencestudent->setEvalcompetence($evalcompetence);
                $entityManager->persist($competencestudent);
            }
            $entityManager->flush();

            return $this->redirectToRoute('evaluation_showarbo', array('id'=>$evaluation->getId()));
        }

        return $this->render('evalcompetence/new.html.twig', [
            'bloc' => $bloc,
            'evalcompetence' => $evalcompetence,
            'evaluation' => $evaluation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="evalcompetence_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Evalcompetence $evalcompetence): Response
    {
        if ($this->getUser() != $evalcompetence->getEvaluation()->getClassroom()->getTeacher()) {
            $this->addFlash('danger', 'Cette évaluation ne vous est pas rattachée.');
            return $this->redirectToRoute('board');
        }
        $form = $this->createForm(EvalcompetenceType::class, $evalcompetence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('evaluation_showarbo', array('id'=>$evalcompetence->getEvaluation()->getId()));
        }

        return $this->render('evalcompetence/edit.html.twig', [
            'evalcompetence' => $evalcompetence,
            'evaluation' => $evalcompetence->getEvaluation(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="evalcompetence_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Evalcompetence $evalcompetence): Response
    {
        if ($this->getUser() != $evalcompetence->getEvaluation()->getClassroom()->getTeacher()) {
            $this->addFlash('danger', 'Cette évaluation ne vous est pas rattachée.');
            return $this->redirectToRoute('board');
        }

        if ($this->isCsrfTokenValid('delete'.$evalcompetence->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($evalcompetence);
            $entityManager->flush();
        }

        return $this->redirectToRoute('evaluation_showarbo', array('id'=>$evalcompetence->getEvaluation()->getId()));
    }
}
