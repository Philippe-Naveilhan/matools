<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Form\ClassroomType;
use App\Repository\ClassroomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/app/classroom")
 */
class ClassroomController extends AbstractController
{
    /**
     * @Route("/new", name="classroom_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $classroom = new Classroom();
        $form = $this->createForm(ClassroomType::class, $classroom);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $classroom->setTeacher($this->getUser());
            $classroom->setActive(true);
            $entityManager->persist($classroom);
            $entityManager->flush();

            return $this->redirectToRoute('board');
        }

        return $this->render('classroom/new.html.twig', [
            'classroom' => $classroom,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="classroom_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Classroom $classroom): Response
    {
        if ($this->getUser() != $classroom->getTeacher()){
            $this->addFlash('danger', 'Cette classe ne vous est pas rattachée.');
            return $this->redirectToRoute('board');
        }
        $form = $this->createForm(ClassroomType::class, $classroom);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('board');
        }

        return $this->render('classroom/edit.html.twig', [
            'classroom' => $classroom,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="classroom_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Classroom $classroom): Response
    {
        if ($this->getUser() != $classroom->getTeacher()) {
        $this->addFlash('danger', 'Cette classe ne vous est pas rattachée.');
        return $this->redirectToRoute('board');
        }

        if ($this->isCsrfTokenValid('delete'.$classroom->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($classroom);
            $entityManager->flush();
        }

        return $this->redirectToRoute('board');
    }

    /**
     * @Route("/{id}/active", name="classroom_active", methods={"GET"})
     */
    public function active(Request $request, Classroom $classroom): Response
    {
        if ($this->getUser() != $classroom->getTeacher()) {
            $this->addFlash('danger', 'Cette classe ne vous est pas rattachée.');
            return $this->redirectToRoute('board');
        }

        if ($classroom->getActive() == true) {
            $classroom->setActive(false);
        } else {
            $classroom->setActive(true);
        }
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('board');
    }
}
