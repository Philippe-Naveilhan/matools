<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

class BoardController extends AbstractController
{
    /**
     * @Route("/app/board", name="board")
     */
    public function index(): Response
    {
        $user =$this->getUser();
        $classrooms = $user->getClassrooms();
        $evaluations = $user->getEvaluations();
        return $this->render('board/index.html.twig', [
            'classrooms' => $classrooms,
            'evaluations' => $evaluations,
        ]);
    }
}
