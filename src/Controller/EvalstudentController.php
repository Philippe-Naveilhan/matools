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
     * @Route("/", name="evalstudent_index", methods={"GET"})
     */
    public function index(EvalstudentRepository $evalstudentRepository): Response
    {
        return $this->render('evalstudent/index.html.twig', [
            'evalstudents' => $evalstudentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="evalstudent_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $evalstudent = new Evalstudent();
        $form = $this->createForm(EvalstudentType::class, $evalstudent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($evalstudent);
            $entityManager->flush();

            return $this->redirectToRoute('evalstudent_index');
        }

        return $this->render('evalstudent/new.html.twig', [
            'evalstudent' => $evalstudent,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="evalstudent_show", methods={"GET"})
     */
    public function show(Evalstudent $evalstudent): Response
    {
        return $this->render('evalstudent/show.html.twig', [
            'evalstudent' => $evalstudent,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="evalstudent_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Evalstudent $evalstudent): Response
    {
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

    /**
     * @Route("/{id}", name="evalstudent_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Evalstudent $evalstudent): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evalstudent->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($evalstudent);
            $entityManager->flush();
        }

        return $this->redirectToRoute('evalstudent_index');
    }
}
