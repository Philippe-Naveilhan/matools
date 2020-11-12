<?php

namespace App\Controller;

use App\Entity\Circo;
use App\Form\CircoType;
use App\Repository\CircoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/circo")
 */
class CircoController extends AbstractController
{
    /**
     * @Route("/", name="circo_index", methods={"GET"})
     */
    public function index(CircoRepository $circoRepository): Response
    {
        return $this->render('circo/index.html.twig', [
            'circos' => $circoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="circo_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $circo = new Circo();
        $form = $this->createForm(CircoType::class, $circo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($circo);
            $entityManager->flush();

            return $this->redirectToRoute('circo_index');
        }

        return $this->render('circo/new.html.twig', [
            'circo' => $circo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="circo_show", methods={"GET"})
     */
    public function show(Circo $circo): Response
    {
        return $this->render('circo/show.html.twig', [
            'circo' => $circo,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="circo_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Circo $circo): Response
    {
        $form = $this->createForm(CircoType::class, $circo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('circo_index');
        }

        return $this->render('circo/edit.html.twig', [
            'circo' => $circo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="circo_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Circo $circo): Response
    {
        if ($this->isCsrfTokenValid('delete'.$circo->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($circo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('circo_index');
    }
}
