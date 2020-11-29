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
        if($user->getFirstname() && $user->getLastname() && $user->getSchool()) {
            $classrooms = $user->getClassrooms();
            return $this->render('board/index.html.twig', [
                'classrooms' => $classrooms,
            ]);
        } else {
            return $this->render('user/show.html.twig', [
                'message' => 'merci de compléter votre profil',
                ]);
        }

    }
}

