<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Entity\Student;
use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * @Route("/app/etiquettes")
 */
class EtiquettesController extends AbstractController
{
    /**
     * @Route("/{id}", name="etiquettes", methods={"GET"})
     */
    public function index(Classroom $classroom)
    {
        return $this->render('etiquettes/index.html.twig', [
            'controller_name' => 'EtiquettesController',
            'classroom' => $classroom
        ]);
    }

    /**
     * @Route("/cantine/{id}", name="etiquettes_cantine")
     */
    public function etiquettesCantine(Classroom $classroom): Response
    {
        if(isset($_GET['select'])){
            $students = $this->getDoctrine()
                ->getRepository(Student::class)
                ->findBy(['classroom'=>$classroom, 'level'=>$_GET['select']]);
        } else {
            $students = $this->getDoctrine()
                ->getRepository(Student::class)
                ->findBy(['classroom'=>$classroom]);
        }

//        return $this->render('etiquettes/cantine.html.twig');

        // Configure Dompdf according to your needs

        // Instantiate Dompdf with our options
        $pdfOptions = new Options();
        $pdfOptions->setDefaultFont('Arial');
        $dompdf = new Dompdf($pdfOptions);
//        $dompdf->getOptions()->setChroot('./public/build');

        // Load HTML to Dompdf
        $dompdf->loadHtml('Hello Word');

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('etiquettes/cantine.html.twig', [
            'dompdf' => $dompdf->getOptions()->getDefaultFont(),
            'students' =>$students
        ]);
        // Render the HTML as PDF
        $dompdf->render($html);

        // the file's name
        $name = 'etiquettes.pdf';
        // Output the generated PDF to Browser (inline view)
        $dompdf->stream('tata.pdf');
        dd($pdfOptions);
        $dompdf->stream($name);
        return new Response("The PDF file has been succesfully generated !");

    }

    /**
     * @Route("/table", name="etiquettes_table", methods={"GET"})
     */
    public function etiquettesTable(Request $request)
    {
        $select=$_GET['select'];
        $students = $this->getDoctrine()
            ->getRepository(Student::class)
            ->findBy([], ['firstname' => "ASC"]);

        return $this->render('etiquettes/table.html.twig', [
            'students' => $students,
            'select'=>$select,
        ]);
    }

    /**
     * @Route("/comportement", name="etiquettes_comportement", methods={"GET"})
     */
    public function etiquettesComportement(Request $request)
    {
        $select=$_GET['select'];
        $students = $this->getDoctrine()
            ->getRepository(Student::class)
            ->findBy([], ['firstname' => "ASC"]);

        return $this->render('etiquettes/comportement.html.twig', [
            'students' => $students,
            'select'=>$select,
        ]);
    }

    /**
     * @Route("/presenceGS", name="etiquettes_presence_GS", methods={"GET"})
     */
    public function etiquettesPresenceGS(Request $request)
    {
        $select=$_GET['select'];
        $students = $this->getDoctrine()
            ->getRepository(Student::class)
            ->findBy([], ['firstname' => "ASC"]);

        return $this->render('etiquettes/presenceGS.html.twig', [
            'students' => $students,
            'select'=>$select,
        ]);
    }

    /**
     * @Route("/presencePS", name="etiquettes_presence_PS", methods={"GET"})
     */
    public function etiquettespresencePS(Request $request)
    {
        $select=$_GET['select'];
        $students = $this->getDoctrine()
            ->getRepository(Student::class)
            ->findBy([], ['firstname' => "ASC"]);

        return $this->render('etiquettes/presencePS.html.twig', [
            'students' => $students,
            'select'=>$select,
        ]);
    }

    /**
     * @Route("/porteManteau", name="etiquettes_porteManteau", methods={"GET"})
     */
    public function etiquettesPorteManteau(Request $request)
    {
        $select=$_GET['select'];
        $students = $this->getDoctrine()
            ->getRepository(Student::class)
            ->findBy([], ['firstname' => "ASC"]);

        return $this->render('etiquettes/porteManteau.html.twig', [
            'students' => $students,
            'select'=>$select,
        ]);
    }

    /**
     * @Route("/casier", name="etiquettes_casier", methods={"GET"})
     */
    public function etiquettesCasier(Request $request)
    {
        $select=$_GET['select'];
        $students = $this->getDoctrine()
            ->getRepository(Student::class)
            ->findBy([], ['firstname' => "ASC"]);

        return $this->render('etiquettes/casier.html.twig', [
            'students' => $students,
            'select'=>$select,
        ]);
    }

    /**
     * @Route("/{id}", name="etiquettes_by_student", methods={"GET"})
     */
    public function etiquettesByStudent(Request $request, Student $student)
    {
        return $this->render('etiquettes/by_student.html.twig', [
            'student' => $student,
            'count' => rand(1,7),
        ]);
    }
}
