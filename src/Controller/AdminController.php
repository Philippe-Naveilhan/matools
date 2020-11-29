<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/graphic", name="admin_graphic")
     */
    public function index(): Response
    {
        return $this->render('graphic/index.html.twig', [
            'controller_name' => 'GraphicController',
        ]);
    }

    /**
     * @Route("/", name="admin_index")
     */
    public function bas(): Response
    {
        return $this->render('admin/index.html.twig');
    }
}
