<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Entity\Competencestudent;
use App\Entity\Evalstudent;
use App\Entity\Student;
use App\Form\StudentType;
use App\Repository\ClassroomRepository;
use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/app/student")
 */
class StudentController extends AbstractController
{
    /**
     * @Route("/{id}", name="student_by_classroom", methods={"GET"})
     */
    public function by_class(Classroom $classroom): Response
    {
        if ($this->getUser() != $classroom->getTeacher()) {
            $this->addFlash('danger', 'Cette classe ne vous est pas rattachée.');
            return $this->redirectToRoute('board');
        }
        return $this->render('student/index.html.twig', [
            'classroom' => $classroom,
        ]);
    }

    /**
     * @Route("/new/{id}", name="student_new", methods={"GET","POST"})
     */
    public function new(Request $request, Classroom $classroom): Response
    {
        if ($this->getUser() != $classroom->getTeacher()) {
            $this->addFlash('danger', 'Cette classe ne vous est pas rattachée.');
            return $this->redirectToRoute('board');
        }

        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $student->setClassroom($classroom);
            $entityManager->persist($student);
            $entityManager->flush();

//      Création des EvalStudents & CompetenceStudent à la création d'un élève
//      si des évaluations sont déjà créées.

            foreach($classroom->getEvaluations() as $evaluation){
                if($evaluation->getLevel()->getId() == $student->getLevel()->getId()){
                    $evalstudent = new Evalstudent();
                    $entityManager = $this->getDoctrine()->getManager();
                    $evalstudent->setStudent($student);
                    $evalstudent->setEvaluation($evaluation);
                    $entityManager->persist($evalstudent);
                    $entityManager->flush();
                    foreach($evaluation->getEvalcompetences() as $competence){
                        $competencestudent = new Competencestudent();
                        $entityManager = $this->getDoctrine()->getManager();
                        $competencestudent->setEvalstudent($evalstudent);
                        $competencestudent->setEvalcompetence($competence);
                        $entityManager->persist($competencestudent);
                        $entityManager->flush();
                    }
                }
            }

            $this->addFlash('success', 'La fiche de l\'élève a été créée avec succès.');
            return $this->redirectToRoute('student_by_classroom', array('id'=>$classroom->getId()));
        }

        return $this->render('student/new.html.twig', [
            'student' => $student,
            'classroom' => $classroom,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="student_show", methods={"GET"})
     */
    public function show(Student $student): Response
    {

        return $this->render('student/show.html.twig', [
            'student' => $student,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="student_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Student $student): Response
    {
        if ($this->getUser() != $student->getClassroom()->getTeacher()) {
            $this->addFlash('danger', 'Cet élève ne vous est pas rattaché.');
            return $this->redirectToRoute('board');
        }

        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'La fiche de l\'élève a été modifiée avec succès.');
            return $this->render('student/index.html.twig', [
                'classroom' => $student->getClassroom(),
            ]);
        }

        return $this->render('student/edit.html.twig', [
            'student' => $student,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="student_delete", methods={"DELETE","GET","POST"})
     */
    public function delete(Request $request, Student $student): Response
    {
        if ($this->getUser() != $student->getClassroom()->getTeacher()) {
            $this->addFlash('danger', 'Cet élève ne vous est pas rattaché.');
            return $this->redirectToRoute('board');
        }

        if ($this->isCsrfTokenValid('delete'.$student->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($student);
            $entityManager->flush();
        }

        $this->addFlash('success', 'La fiche de l\'élève a été supprimée avec succès.');
        return $this->redirectToRoute('student_by_classroom', array('id'=>$student->getClassroom()->getId()));
    }
}
