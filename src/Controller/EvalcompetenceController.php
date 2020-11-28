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
     * @Route("/", name="evalcompetence_index", methods={"GET"})
     */
    public function index(EvalcompetenceRepository $evalcompetenceRepository): Response
    {
        return $this->render('evalcompetence/index.html.twig', [
            'evalcompetences' => $evalcompetenceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{bloc}/{eval}", name="evalcompetence_new", methods={"GET","POST"})
     */
    public function new(Request $request,
                        Evalbloc $bloc,
                        Evaluation $eval,
                        EvalstudentRepository $evalstudentRepository
): Response
    {
        $evalcompetence = new Evalcompetence();
        $form = $this->createForm(EvalcompetenceType::class, $evalcompetence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $evalcompetence->setBloc($bloc);
            $evalcompetence->setEvaluation($eval);
            $entityManager->persist($evalcompetence);
            $entityManager->flush();

            foreach($evalstudentRepository->findBy(['evaluation'=>$eval]) as $evalstudent){
                $entityManager = $this->getDoctrine()->getManager();
                $competencestudent = new Competencestudent();
                $competencestudent->setEvalstudent($evalstudent);
                $competencestudent->setEvalcompetence($evalcompetence);
                $entityManager->persist($competencestudent);
            }
            $entityManager->flush();

            return $this->redirectToRoute('evaluation_show', array('id'=>$eval->getId()));
        }

        return $this->render('evalcompetence/new.html.twig', [
            'bloc' => $bloc,
            'evalcompetence' => $evalcompetence,
            'evaluation' => $eval,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="evalcompetence_show", methods={"GET"})
     */
    public function show(Evalcompetence $evalcompetence): Response
    {
        return $this->render('evalcompetence/show.html.twig', [
            'evalcompetence' => $evalcompetence,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="evalcompetence_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Evalcompetence $evalcompetence): Response
    {
        $form = $this->createForm(EvalcompetenceType::class, $evalcompetence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('evaluation_show', array('id'=>$evalcompetence->getEvaluation()->getId()));
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
        if ($this->isCsrfTokenValid('delete'.$evalcompetence->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($evalcompetence);
            $entityManager->flush();
        }

        return $this->redirectToRoute('evaluation_show', array('id'=>$evalcompetence->getEvaluation()->getId()));
    }
}
