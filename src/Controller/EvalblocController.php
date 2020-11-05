<?php

namespace App\Controller;

use App\Entity\Evalbloc;
use App\Form\EvalblocType;
use App\Repository\EvalblocRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/evalbloc")
 */
class EvalblocController extends AbstractController
{
    /**
     * @Route("/", name="evalbloc_index", methods={"GET"})
     */
    public function index(EvalblocRepository $evalblocRepository): Response
    {
        return $this->render('evalbloc/index.html.twig', [
            'evalblocs' => $evalblocRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="evalbloc_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $evalbloc = new Evalbloc();
        $form = $this->createForm(EvalblocType::class, $evalbloc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($evalbloc);
            $entityManager->flush();

            return $this->redirectToRoute('evalbloc_index');
        }

        return $this->render('evalbloc/new.html.twig', [
            'evalbloc' => $evalbloc,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="evalbloc_show", methods={"GET"})
     */
    public function show(Evalbloc $evalbloc): Response
    {
        return $this->render('evalbloc/show.html.twig', [
            'evalbloc' => $evalbloc,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="evalbloc_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Evalbloc $evalbloc): Response
    {
        $form = $this->createForm(EvalblocType::class, $evalbloc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('evalbloc_index');
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
        if ($this->isCsrfTokenValid('delete'.$evalbloc->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($evalbloc);
            $entityManager->flush();
        }

        return $this->redirectToRoute('evalbloc_index');
    }
}
