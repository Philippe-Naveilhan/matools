<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Repository\StudentRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("app/lists")
 */
class ListsController extends AbstractController
{
    /**
     * @Route("/{id}", name="lists")
     */
    public function index(Classroom $classroom): Response
    {
        $levels = [];
        foreach ($classroom->getStudents() as $student) {
            $levels[$student->getLevel()->getId()] = $student->getLevel()->getName();
        }
        return $this->render('lists/index.html.twig', [
            'levels' => $levels,
            'classroom' => $classroom,
        ]);
    }

    /**
     * @Route("/list-documents/{id}/{level}", name="listDocuments")
     */
    public function listDocument(Classroom $classroom, $level, StudentRepository $studentRepository): Response
    {
        if($level != 'all') {
            $students = $studentRepository->findBy(['classroom'=>$classroom, 'level'=>$level]);
        } else {
            $students = $classroom->getStudents();
        }
        // Configure Dompdf according to your needs

        // Instantiate Dompdf with our options
        $options = new Options();
        $options->setDefaultFont('Helvetica');
        $options->setIsRemoteEnabled(true);
        $options->setChroot('');
        $options->setIsHtml5ParserEnabled(true);
        $dompdf = new Dompdf($options);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'landscape');

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('lists/listDocuments.html.twig', [
            'students' => $students,
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // Render the HTML as PDF
        $dompdf->render();

        // the file's name
        $name = 'Liste_des_documents.pdf';
        // Output the generated PDF to Browser (inline view)
        $dompdf->stream($name, [
            "Attachment" => false
        ]);
    }
}
