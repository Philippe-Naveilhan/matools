<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GraphicController extends AbstractController
{
    /**
     * @Route("/admin/graphic", name="graphic")
     */
    public function index(): Response
    {
        return $this->render('graphic/index.html.twig', [
            'controller_name' => 'GraphicController',
        ]);
    }
}
