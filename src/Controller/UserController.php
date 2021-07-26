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
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("app/user")
 */
class UserController extends AbstractController
{
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
    public function select_district(Academy $academy): Response
    {
        $array = [];
        $districts = $academy->getDistricts();
        foreach ($districts as $district){
            $array[$district->getId()] = $district->getName();
    }
        $disctrictsJSON = json_encode($array);
        return $this->json([
            'code' => 200,
            'message' => $disctrictsJSON
        ], 200);
    }

    /**
     * @Route("/select_circo/{id}", name="select_circo", methods={"GET","POST"})
     */
    public function select_circo(District $district): Response
    {
        $array = [];
        $circos = $district->getCircos();
        foreach ($circos as $circo){
            $array[$circo->getId()] = $circo->getName();
        }
        $circosJSON = json_encode($array);
        return $this->json([
            'code' => 200,
            'message' => $circosJSON
        ]);
    }

    /**
     * @Route("/select_school/{id}", name="select_school", methods={"GET","POST"})
     */
    public function select_school(Circo $circo): Response
    {
        $array = [];
        $schools = $circo->getSchools();
        foreach ($schools as $school){
            $array[$school->getId()] = $school->getName();
        }
        $schoolsJSON = json_encode($array);
        return $this->json([
            'code' => 200,
            'message' => $schoolsJSON,
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
