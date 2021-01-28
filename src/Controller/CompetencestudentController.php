<?php

namespace App\Controller;

use App\Entity\Competencestudent;
use App\Entity\Evalcompetence;
use App\Entity\Evalstudent;
use App\Form\CompetencestudentType;
use App\Repository\CompetencestudentRepository;
use App\Repository\EvalcompetenceRepository;
use App\Repository\EvalstudentRepository;
use App\Service\Completion;
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
     * @Route("/saveByCompetence/{id}", name="evalByCompetence_save", methods={"GET","POST"})
     */
    public function saveByCompetence(Request $request,
                                     Evalcompetence $evalcompetence,
                                     EvalstudentRepository $evalstudentRepository,
                                     CompetencestudentRepository $competencestudentRepository,
                                     EvalcompetenceRepository $evalcompetenceRepository,
                                     Completion $completion
    ): Response
    {
        if ($this->getUser() != $evalcompetence->getEvaluation()->getClassroom()->getTeacher()) {
            $this->addFlash('danger', 'Cet évaluation ne vous est pas rattachée.');
            return $this->redirectToRoute('board');
        }
        $listCompetenceByStudent = $competencestudentRepository->findBy(['evalcompetence'=>$evalcompetence]);
        $competenceByStudent=[];
        $key="";
        foreach($listCompetenceByStudent as $comp){
            $key = $comp->getEvalstudent()->getStudent()->getFirstname()."_".$comp->getEvalstudent()->getStudent()->getLastname();
            $competenceByStudent[$key]=$comp;
        }
        ksort($competenceByStudent);
        $evaluation = $evalcompetence->getEvaluation();
        if(isset($_POST['evaluation'])){
            foreach($_POST['evaluation'] as $key=>$value)
            {
                $competencestudent = $competencestudentRepository->findOneBy(['evalstudent'=>$key, 'evalcompetence'=>$evalcompetence->getId()]);
                if($competencestudent == true){
                    $entityManager = $this->getDoctrine()->getManager();
                    if(isset($value['note'])) {
                        $competencestudent->setNote($value['note']);
                    }
                    $competencestudent->setComment($value['comment']);
                    $entityManager->persist($competencestudent);
                }
            }
            $entityManager->flush();

            $entityManager = $this->getDoctrine()->getManager();
            $result = $completion->completion($evalcompetence->getId());
            $evalcompetence->setCompletion($result);
            $entityManager->persist($evalcompetence);
            $entityManager->flush();

            return $this->redirectToRoute('evaluation_show', ['id'=>$evaluation->getId()]);
        }

        return $this->render('competencestudent/index.html.twig', [
            'competences' => $competenceByStudent,
            'evaluation' => $evaluation,
            'competence' => $evalcompetence,
        ]);
    }
}
