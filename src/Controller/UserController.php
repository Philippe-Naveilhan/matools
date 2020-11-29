<?php

namespace App\Controller;

use App\Entity\Academy;
use App\Entity\Circo;
use App\Entity\District;
use App\Entity\School;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\AcademyRepository;
use App\Repository\DistrictRepository;
use App\Repository\CircoRepository;
use App\Repository\SchoolRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("app/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/profil", name="user_show", methods={"GET"})
     */
    public function show(): Response
    {
        return $this->render('user/show.html.twig');
    }

    /**
     * @Route("/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_show');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }

    /**
     * @Route("/select_academy", name="select_academy", methods={"GET","POST"})
     */
    public function select_academy(AcademyRepository $academyRepository): Response
    {
        $academies = $academyRepository->findBy([],['name'=>'ASC']);
        return $this->render('user/select_academy.html.twig', [
            'academies' => $academies,
        ]);
    }

    /**
     * @Route("/select_district/{id}", name="select_district", methods={"GET","POST"})
     */
    public function select_district(DistrictRepository $districtRepository, Academy $academy): Response
    {
        $districts = $districtRepository->findBy(['inspection'=>$academy->getId()],['name'=>'ASC']);
        return $this->render('user/select_district.html.twig', [
            'districts' => $districts,
        ]);
    }

    /**
     * @Route("/select_circo/{id}", name="select_circo", methods={"GET","POST"})
     */
    public function select_circo(CircoRepository $circoRepository, District $district): Response
    {
        $circos = $circoRepository->findBy(['district'=>$district->getId()],['name'=>'ASC']);
        return $this->render('user/select_circo.html.twig', [
            'circos' => $circos,
        ]);
    }

    /**
     * @Route("/select_school/{id}", name="select_school", methods={"GET","POST"})
     */
    public function select_school(SchoolRepository $schoolRepository, Circo $circo): Response
    {
        $schools = $schoolRepository->findBy(['circo'=>$circo->getId()],['name'=>'ASC']);
        return $this->render('user/select_school.html.twig', [
            'schools' => $schools,
        ]);
    }

    /**
     * @Route("/select_school_save/{id}", name="select_school_save", methods={"GET","POST"})
     */
    public function select_school_save(UserRepository $userRepository, School $school): Response
    {
        $teacher = $this->getUser();
        $teacher->setSchool($school);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('user_show');
    }
}
