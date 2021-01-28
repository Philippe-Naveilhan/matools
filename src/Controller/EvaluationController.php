<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Evaltheme;
use App\Repository\CompetencestudentRepository;
use App\Repository\EvalthemeRepository;
use App\Entity\Evalcategory;
use App\Entity\Evalbloc;
use App\Repository\EvalblocRepository;
use App\Entity\Evalcompetence;
use App\Repository\EvalcompetenceRepository;
use App\Entity\Classroom;
use App\Entity\Evalstudent;
use App\Entity\Evaluation;
use App\Form\EvaluationType;
use App\Repository\EvaluationRepository;
use App\Repository\LevelRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\Completion;

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
        if ($this->getUser() != $classroom->getTeacher()) {
            $this->addFlash('danger', 'Cette classe ne vous est pas rattachée.');
            return $this->redirectToRoute('board');
        }

        return $this->render('evaluation/index.html.twig', [
            'classroom' => $classroom,
        ]);
    }

    /**
     * @Route("/new/{id}", name="evaluation_new", methods={"GET","POST"})
     */
    public function new(Request $request,
                        Classroom $classroom,
                        LevelRepository $levelRepository
    ): Response
    {
        if ($this->getUser() != $classroom->getTeacher()) {
            $this->addFlash('danger', 'Cette classe ne vous est pas rattachée.');
            return $this->redirectToRoute('board');
        }
        if (isset($_POST['evaluation'])) {
            $evaluation = new Evaluation();
            $entityManager = $this->getDoctrine()->getManager();
            $evaluation->setClassroom($classroom);
            $evaluation->setName($_POST['evaluation']['name']);
            $evaluation->setLevel($levelRepository->findOneBy(['id'=>$_POST['evaluation']['level']]));
            $entityManager->persist($evaluation);
            $entityManager->flush();

            // create evalstudent for each student
            $students = $classroom->getStudents();
            foreach($students as $student)
            {
                if($student->getLevel()->getId() === $evaluation->getLevel()->getId()){
                    $evalStudent = new Evalstudent;
                    $entityManager = $this->getDoctrine()->getManager();
                    $evalStudent->setStudent($student);
                    $evalStudent->setEvaluation($evaluation);
                    $entityManager->persist($evalStudent);
                }
            }
            $arbothemes = [
                "Mobiliser le langage dans toutes ses dimensions" => [
                    "L'oral" => [
                        "Commencer à refléchir sur la langue et à acquérir une conscience phonologique"
                    ],
                    "L'écrit" => [
                        "Découvrir le principe alphabétique",
                        "Commencer à écrire tout seul"
                    ]
                ],
                "Agir, s'exprimer, comprendre à travers l'activité physique" => [
                    "unique" => [
                        "Collaborer, coopérer, s'opposer"
                    ]
                ],
                "Agir, s'exprimer, comprendre à travers les activités artistiques" => [
                    "unique" => [
                        "Univers sonores",
                        "Les productions plastiques et visuelles"
                    ]
                ],
                "Construire les premiers outils pour structurer sa pensée" => [
                    "unique" => [
                        "Les nombres et leurs utilisations",
                        "Formes, grandeurs et suites organisées"
                    ]
                ],
                "Explorer le monde" => [
                    "unique" => [
                        "Le vivant, la matière, les objets"
                    ]
                ],
                "Apprendre ensemble et vivre ensemble" => [
                    "unique" => [
                        "Comprendre la fonction de l'école, se construire comme une personne singulière au sein du groupe"
                    ]
                ]
            ];
            foreach ($arbothemes as $arbotheme => $arbocategories){
            // create default themes
            $theme = new Evaltheme;
            $entityManager = $this->getDoctrine()->getManager();
            $theme->setName($arbotheme);
            $theme->setEvaluation($evaluation);
            $entityManager->persist($theme);
            $entityManager->flush();
                foreach ($arbocategories as $arbocategory => $arboblocs){
                    // create default category
                    $category = new Evalcategory;
                    $entityManager = $this->getDoctrine()->getManager();
                    $category->setName($arbocategory);
                    $category->setTheme($theme);
                    $entityManager->persist($category);
                    $entityManager->flush();
                    foreach  ($arboblocs as $arbobloc){
                        // create default bloc
                        $bloc = new Evalbloc;
                        $entityManager = $this->getDoctrine()->getManager();
                        $bloc->setName($arbobloc);
                        $bloc->setCategory($category);
                        $entityManager->persist($bloc);
                    }
                    $entityManager->flush();
                }
            }

            return $this->redirectToRoute('evaluation_index', array('id'=>$classroom->getId()));
        }

        return $this->render('evaluation/new.html.twig', [
            'classroom' => $classroom,
        ]);
    }

    /**
     * @Route("/new_empty/{id}", name="evaluation_new_empty", methods={"GET","POST"})
     */
    public function new_empty(Request $request,
                        Classroom $classroom,
                        LevelRepository $levelRepository
    ): Response
    {
        if ($this->getUser() != $classroom->getTeacher()) {
            $this->addFlash('danger', 'Cette classe ne vous est pas rattachée.');
            return $this->redirectToRoute('board');
        }
        if (isset($_POST['evaluation'])) {
            $evaluation = new Evaluation();
            $entityManager = $this->getDoctrine()->getManager();
            $evaluation->setClassroom($classroom);
            $evaluation->setName($_POST['evaluation']['name']);
            $evaluation->setLevel($levelRepository->findOneBy(['id'=>$_POST['evaluation']['level']]));
            $entityManager->persist($evaluation);
            $entityManager->flush();

            // create evalstudent for each student
            $students = $classroom->getStudents();
            foreach($students as $student)
            {
                if($student->getLevel()->getId() === $evaluation->getLevel()->getId()){
                    $evalStudent = new Evalstudent;
                    $entityManager = $this->getDoctrine()->getManager();
                    $evalStudent->setStudent($student);
                    $evalStudent->setEvaluation($evaluation);
                    $entityManager->persist($evalStudent);
                }
            }
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
    public function show(Evaluation $evaluation): Response
    {
        if ($this->getUser() != $evaluation->getClassroom()->getTeacher()) {
            $this->addFlash('danger', 'Cette évaluation ne vous est pas rattachée.');
            return $this->redirectToRoute('board');
        }

        return $this->render('evaluation/show.html.twig', [
            'evaluation' => $evaluation
        ]);
    }

    /**
     * @Route("/showarbo/{id}", name="evaluation_showarbo", methods={"GET"})
     */
    public function showarbo(Evaluation $evaluation): Response
    {
        if ($this->getUser() != $evaluation->getClassroom()->getTeacher()) {
            $this->addFlash('danger', 'Cette évaluation ne vous est pas rattachée.');
            return $this->redirectToRoute('board');
        }

        return $this->render('evaluation/show_arbo.html.twig', [
            'evaluation' => $evaluation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="evaluation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request,
                         Evaluation $evaluation,
                         LevelRepository $levelRepository): Response
    {
        if ($this->getUser() != $evaluation->getClassroom()->getTeacher()) {
            $this->addFlash('danger', 'Cette évaluation ne vous est pas rattachée.');
            return $this->redirectToRoute('board');
        }

        $form = $this->createForm(EvaluationType::class, $evaluation);
        $form->handleRequest($request);

        if (isset($_POST['evaluation'])) {
            $entityManager = $this->getDoctrine()->getManager();
            $evaluation->setName($_POST['evaluation']['name']);
            $entityManager->persist($evaluation);
            $entityManager->flush();

            return $this->redirectToRoute('evaluation_index', array('id'=>$evaluation->getClassroom()->getId()));
        }

        return $this->render('evaluation/edit.html.twig', [
            'classroom' => $evaluation->getClassroom(),
            'evaluation' => $evaluation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="evaluation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Evaluation $evaluation): Response
    {
        if ($this->getUser() != $evaluation->getClassroom()->getTeacher()) {
            $this->addFlash('danger', 'Cette évaluation ne vous est pas rattachée.');
            return $this->redirectToRoute('board');
        }

        if ($this->isCsrfTokenValid('delete'.$evaluation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($evaluation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('evaluation_index', array('id'=>$evaluation->getClassroom()->getId()));
    }

    /**
     * @Route("/enr/{id}", name="evaluation_enr", methods={"GET"})
     */
    public function enr(EvalcompetenceRepository $evalcompetenceRepository,
                         Evaluation $evaluation,
                         EvalthemeRepository $evalthemeRepository): Response
    {
        if ($this->getUser() != $evaluation->getClassroom()->getTeacher()) {
            $this->addFlash('danger', 'Cette évaluation ne vous est pas rattachée.');
            return $this->redirectToRoute('board');
        }
        $themes = $evalthemeRepository->findAll();
        $competences = $evalcompetenceRepository->findBy(['evaluation'=>$evaluation]);

        return $this->render('evaluation/show.html.twig', [
            'evaluation' => $evaluation,
            'competences' => $competences,
            'themes' => $themes,
        ]);
    }

    /**
     * @Route("/updown/{id}/{direction}", name="evaluation_updown", methods={"GET"})
     */
    public function updown(Evalcompetence $evalcompetence,
                           $direction,
                           EvalcompetenceRepository $evalcompetenceRepository): Response
    {
        if ($this->getUser() != $evalcompetence->getEvaluation()->getClassroom()->getTeacher()) {
            $this->addFlash('danger', 'Cette évaluation ne vous est pas rattachée.');
            return $this->redirectToRoute('board');
        }

        $entityManager = $this->getDoctrine()->getManager();
        if($direction == 'up'){
            $otherCompetence = $evalcompetenceRepository->findOneBy(['bloc'=>$evalcompetence->getBloc(), 'placeorder'=>($evalcompetence->getPlaceorder()+1)]);
            $evalcompetence->setPlaceorder($evalcompetence->getPlaceorder()+1);
            $otherCompetence->setPlaceorder($otherCompetence->getPlaceorder()-1);
        }
        elseif ($direction == 'down') {
            $otherCompetence = $evalcompetenceRepository->findOneBy(['bloc'=>$evalcompetence->getBloc(), 'placeorder'=>($evalcompetence->getPlaceorder()-1)]);
            $evalcompetence->setPlaceorder($evalcompetence->getPlaceorder()-1);
            $otherCompetence->setPlaceorder($otherCompetence->getPlaceorder()+1);
        }
        $entityManager->flush();

        return $this->redirectToRoute('evaluation_showarbo', array('id'=>$evalcompetence->getEvaluation()->getId()));
    }

    /**
     * @Route("/appreciation/{id}", name="evaluation_appreciation", methods={"GET"})
     */
    public function appreciation(Evaluation $evaluation): Response
    {
        if ($this->getUser() != $evaluation->getClassroom()->getTeacher()) {
            $this->addFlash('danger', 'Cette évaluation ne vous est pas rattachée.');
            return $this->redirectToRoute('board');
        }

        return $this->render('evaluation/comments.html.twig', [
            'evaluation' => $evaluation,
        ]);
    }
}
