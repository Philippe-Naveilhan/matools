<?php

namespace App\Controller;

use App\Entity\Evalcompetence;
use App\Entity\Classroom;
use App\Entity\Evaltheme;
use App\Entity\User;
use App\Entity\Evaluation;
use App\Form\EvaluationType;
use App\Repository\EvalblocRepository;
use App\Repository\EvalcompetenceRepository;
use App\Repository\EvalthemeRepository;
use App\Repository\EvaluationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/app/evaluation")
 */
class EvaluationController extends AbstractController
{
    /**
     * @Route("/{id}", name="evaluation_index", methods={"GET"})
     */
    public function index(Classroom $classroom): Response
    {
        return $this->render('evaluation/index.html.twig', [
            'classroom' => $classroom,
        ]);
    }

    /**
     * @Route("/new/{id}", name="evaluation_new", methods={"GET","POST"})
     */
    public function new(Request $request,
                        Classroom $classroom
    ): Response
    {

        if (isset($_POST['evaluation'])) {
            $evaluation = new Evaluation();
            $entityManager = $this->getDoctrine()->getManager();
            $evaluation->setClassroom($classroom);
            $evaluation->setName($_POST['evaluation']['name']);
            $entityManager->persist($evaluation);
            $entityManager->flush();

            return $this->redirectToRoute('evaluation_index', array('id'=>$classroom->getId()));
        }

        return $this->render('evaluation/new.html.twig', [
            'classroom' => $classroom,
        ]);
    }

    /**
     * @Route("/show/{id}", name="evaluation_show", methods={"GET"})
     */
    public function show(EvalcompetenceRepository $evalcompetenceRepository,
                         Evaluation $evaluation,
                         EvalthemeRepository $evalthemeRepository): Response
    {
        $themes = $evalthemeRepository->findAll();
        $competences = $evalcompetenceRepository->findByEvaluation($evaluation);

        return $this->render('evaluation/show.html.twig', [
            'evaluation' => $evaluation,
            'competences' => $competences,
            'themes' => $themes,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="evaluation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Evaluation $evaluation): Response
    {
        $form = $this->createForm(EvaluationType::class, $evaluation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('evaluation_index');
        }

        return $this->render('evaluation/edit.html.twig', [
            'evaluation' => $evaluation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="evaluation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Evaluation $evaluation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evaluation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($evaluation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('evaluation_index', array('id'=>$evaluation->getClassroom()->getId()));
    }

}
