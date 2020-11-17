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

    /**
     * @Route("/admin/qcq", name="qcq")
     */
    public function qcq(): Response
    {
        return $this->render('bundles/TwigBundle/Exception/error404.html.twig', [
            'controller_name' => '404',
        ]);
    }

    /**
     * @Route("/admin/bas", name="bas")
     */
    public function bas(): Response
    {
        return $this->render('bacasable/carousel.html.twig', [
            'controller_name' => '404',
        ]);
    }
}
