<?php

namespace App\Controller;

use App\Entity\Competencestudent;
use App\Entity\Evalcompetence;
use App\Entity\Evalstudent;
use App\Form\CompetencestudentType;
use App\Repository\CompetencestudentRepository;
use App\Repository\EvalstudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("app/competencestudent")
 */
class CompetencestudentController extends AbstractController
{
    /**
     * @Route("/", name="competencestudent_index", methods={"GET"})
     */
    public function index(CompetencestudentRepository $competencestudentRepository): Response
    {
        return $this->render('competencestudent/index.html.twig', [
            'competencestudents' => $competencestudentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="competencestudent_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $competencestudent = new Competencestudent();
        $form = $this->createForm(CompetencestudentType::class, $competencestudent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($competencestudent);
            $entityManager->flush();

            return $this->redirectToRoute('competencestudent_index');
        }

        return $this->render('competencestudent/new.html.twig', [
            'competencestudent' => $competencestudent,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="competencestudent_show", methods={"GET"})
     */
    public function show(Competencestudent $competencestudent): Response
    {
        return $this->render('competencestudent/show.html.twig', [
            'competencestudent' => $competencestudent,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="competencestudent_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Competencestudent $competencestudent): Response
    {
        $form = $this->createForm(CompetencestudentType::class, $competencestudent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('competencestudent_index');
        }

        return $this->render('competencestudent/edit.html.twig', [
            'competencestudent' => $competencestudent,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="competencestudent_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Competencestudent $competencestudent): Response
    {
        if ($this->isCsrfTokenValid('delete'.$competencestudent->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($competencestudent);
            $entityManager->flush();
        }

        return $this->redirectToRoute('competencestudent_index');
    }

    /**
     * @Route("/saveByCompetence/{id}", name="evalByCompetence_save", methods={"GET","POST"})
     */
    public function saveByCompetence(Request $request,
                                     Evalcompetence $evalcompetence,
                                     EvalstudentRepository $evalstudentRepository
    ): Response
    {
        $evaluation = $evalcompetence->getEvaluation();
        $evalstudents = $evalstudentRepository->findBy(['evaluation'=>$evaluation]);
        $competencestudent = new Competencestudent();
        $form = $this->createForm(CompetencestudentType::class, $competencestudent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($competencestudent);
            $entityManager->flush();

            return $this->redirectToRoute('competencestudent_index');
        }

        return $this->render('competencestudent/new.html.twig', [
            'competencestudent' => $competencestudent,
            'form' => $form->createView(),
        ]);
    }
}
