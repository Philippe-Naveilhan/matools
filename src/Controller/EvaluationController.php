<?php

namespace App\Controller;

use App\Entity\Evalcompetence;
use App\Entity\User;
use App\Entity\Evaluation;
use App\Form\EvaluationType;
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
     * @Route("/", name="evaluation_index", methods={"GET"})
     */
    public function index(EvaluationRepository $evaluationRepository): Response
    {
        return $this->render('evaluation/index.html.twig', [
            'evaluations' => $evaluationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="evaluation_new", methods={"GET","POST"})
     */
    public function new(Request $request,
                        EvalcompetenceRepository $evalcompetenceRepository,
                        EvalthemeRepository $evalthemeRepository
    ): Response
    {
        $competences = $evalcompetenceRepository->findAll();
        $themes = $evalthemeRepository->findAll();
        $listecompetences = [];
        foreach($competences as $competence)
        {
            $listecompetences[$competence->getBloc()->getCategory()->getTheme()->getName()][$competence->getBloc()->getCategory()->getName()][$competence->getBloc()->getName()][$competence->getId()] = $competence->getName();
        }
//        $evaluation = new Evaluation();
//        $form = $this->createForm(EvaluationType::class, $evaluation);
//        $form->handleRequest($request);
//        if ($form->isSubmitted() && $form->isValid()) {
//            $entityManager = $this->getDoctrine()->getManager();
//            $evaluation->setTeacher($this->getUser());
//            $entityManager->persist($evaluation);
//            $entityManager->flush();
//
//            return $this->redirectToRoute('evaluation_index');
//        }

        if (isset($_POST['evaluation'])) {
            $evaluation = new Evaluation();
            $entityManager = $this->getDoctrine()->getManager();
            $evaluation->setTeacher($this->getUser());
            $evaluation->setName($_POST['evaluation']['name']);
            $evaluation->getCompetence();
            foreach ($_POST['evaluation']['competence'] as $competence){
                $evaluation->addCompetence($evalcompetenceRepository->findOneBy(['id'=>$competence]));
            }

            $entityManager->persist($evaluation);
            $entityManager->flush();

            return $this->redirectToRoute('board');
        }

        return $this->render('evaluation/new.html.twig', [
//            'themes' => $themes,
            'themes' => $listecompetences,
//            'evaluation' => $evaluation,
//            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="evaluation_show", methods={"GET"})
     */
    public function show(Evaluation $evaluation): Response
    {
        return $this->render('evaluation/show.html.twig', [
            'evaluation' => $evaluation,
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

        return $this->redirectToRoute('evaluation_index');
    }
}
