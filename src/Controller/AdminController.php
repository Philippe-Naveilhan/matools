<?php

namespace App\Controller;

use App\Form\ChangePasswordFormType;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/test", name="test")
     */
    public function test(Request $request): Response
    {
        $form = $this->createForm(ChangePasswordFormType::class);
        $form->handleRequest($request);

        return $this->render('reset_password/reset.html.twig', [
            'resetForm' => $form->createView(),
            'controller_name' => 'TestController',
        ]);
    }
}
