<?php

namespace App\Controller;

use App\Entity\Evaltheme;
use App\Form\EvalthemeType;
use App\Repository\EvalthemeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/evaltheme")
 */
class EvalthemeController extends AbstractController
{
    /**
     * @Route("/", name="evaltheme_index", methods={"GET"})
     */
    public function index(EvalthemeRepository $evalthemeRepository): Response
    {
        return $this->render('evaltheme/index.html.twig', [
            'evalthemes' => $evalthemeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="evaltheme_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $evaltheme = new Evaltheme();
        $form = $this->createForm(EvalthemeType::class, $evaltheme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($evaltheme);
            $entityManager->flush();

            return $this->redirectToRoute('evaltheme_index');
        }

        return $this->render('evaltheme/new.html.twig', [
            'evaltheme' => $evaltheme,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="evaltheme_show", methods={"GET"})
     */
    public function show(Evaltheme $evaltheme): Response
    {
        return $this->render('evaltheme/show.html.twig', [
            'evaltheme' => $evaltheme,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="evaltheme_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Evaltheme $evaltheme): Response
    {
        $form = $this->createForm(EvalthemeType::class, $evaltheme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('evaltheme_index');
        }

        return $this->render('evaltheme/edit.html.twig', [
            'evaltheme' => $evaltheme,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="evaltheme_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Evaltheme $evaltheme): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evaltheme->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($evaltheme);
            $entityManager->flush();
        }

        return $this->redirectToRoute('evaltheme_index');
    }
}
