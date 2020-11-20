<?php

namespace App\Controller;

use App\Entity\Evalstudent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Classroom;
use App\Entity\Evaluation;
use App\Repository\EvalthemeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * @Route("app/generate_pdf")
 */
class GeneratePDFController extends AbstractController
{
    /**
     * @Route("/", name="generate_pdf")
     */
    public function index(): Response
    {
// Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'landscape');

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('generate_pdf/index.html.twig', [
            'controller_name' => "Welcome to our PDF Test"
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // Render the HTML as PDF
        $dompdf->render();

        // the file's name
        $name = 'test'.rand(0,10).'.pdf';
        // Output the generated PDF to Browser (inline view)
        $dompdf->stream($name, [
            "Attachment" => false
        ]);
    }

    /**
     * @Route("/eval_vierge/{id}", name="eval_vierge")
     */
    public function eval_vierge(Evaluation $evaluation,
                                EvalthemeRepository $evalthemeRepository
    ): Response
    {
        //gestion des données
        $themes = $evalthemeRepository->findAll();
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('generate_pdf/evalViergeByClassroom.html.twig', [
            'themes' => $themes,
            'evaluation' => $evaluation,
            'controller_name' => "Feuille d'évaluation vierge"
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // Render the HTML as PDF
        $dompdf->render();

        // the file's name
        $name = 'evaluation_vierge.pdf';
        // Output the generated PDF to Browser (inline view)
        $dompdf->stream($name, [
            "Attachment" => false
        ]);
    }

    /**
     * @Route("/eval_complete/{id}", name="eval_complete")
     */
    public function eval_complete(Evaluation $evaluation,
                                  EvalthemeRepository $evalthemeRepository
    ): Response
    {
        //gestion des données
        $competences = [];
        foreach($evaluation->getEvalcompetences() as $value){
            $competences[$value->getBloc()->getCategory()->getTheme()->getId()][]=$value;
        }
        $themes = $evalthemeRepository->findAll();
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('generate_pdf/evalCompByClassroom.html.twig', [
            'themes' => $themes,
            'competencesByTheme' => $competences,
            'evaluation' => $evaluation,
            'controller_name' => "Feuille d'évaluation complète"
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // Render the HTML as PDF
        $dompdf->render();

        // the file's name
        $name = 'test'.rand(0,10).'.pdf';
        // Output the generated PDF to Browser (inline view)
        $dompdf->stream($name, [
            "Attachment" => false
        ]);
    }

    /**
     * @Route("/eval_by_studenteval/{id}", name="eval_by_studenteval")
     */
    public function eval_by_studenteval(Evalstudent $evalstudent,
                                  EvalthemeRepository $evalthemeRepository
    ): Response
    {
        //gestion des données
        $competences = [];
        foreach($evalstudent->getCompetencestudents() as $value){
            $competences[$value->getCompetence()->getBloc()->getCategory()->getTheme()->getName()][$value->getCompetence()->getBloc()->getCategory()->getName()][$value->getCompetence()->getBloc()->getName()][$value->getCompetence()->getName()]=$value;
        }
        $themes = $evalthemeRepository->findAll();
        // Configure Dompdf according to your needs

        // Instantiate Dompdf with our options
        $options = new Options();
        $options->setDefaultFont('Helvetica');
        $options->setIsRemoteEnabled(true);
        $options->setChroot('');
        $options->setIsHtml5ParserEnabled(true);
        $dompdf = new Dompdf($options);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('generate_pdf/evalByEvalstudent.html.twig', [
            'dompdf' => $dompdf->getOptions()->getDefaultFont(),
            'themes' => $themes,
            'evalstudent' => $evalstudent,
            'competencesByTheme' => $competences,
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // Render the HTML as PDF
        $dompdf->render();

        // the file's name
        $name = 'evaluation_' . $evalstudent->getStudent()->getFirstname() . '_' . $evalstudent->getStudent()->getLastname() . '.pdf';
        // Output the generated PDF to Browser (inline view)
        $dompdf->stream($name, [
            "Attachment" => false
        ]);
    }


    /**
     * @Route("/eval_by_eval/{id}", name="eval_by_eval")
     */
    public function eval_by_eval(Evaluation $evaluation,
                                 EvalthemeRepository $evalthemeRepository
    ): Response
    {
        //gestion des données
//        $evalsByStudent = [];
//        foreach($evaluation->getEvalstudents() as $evalstudent) {
//            foreach($evalstudent->getCompetencestudents() as $value){
//                $evalsByStudent[$evalstudent->getId()][$value->getCompetence()->getBloc()->getCategory()->getTheme()->getName()][$value->getCompetence()->getBloc()->getCategory()->getName()][$value->getCompetence()->getBloc()->getName()][$value->getCompetence()->getName()]=$value;
//            }
//        }

        $themes = $evalthemeRepository->findAll();
        // Configure Dompdf according to your needs

        // Instantiate Dompdf with our options
        $options = new Options();
        $options->setDefaultFont('Helvetica');
        $options->setIsRemoteEnabled(true);
        $options->setChroot('');
        $options->setIsHtml5ParserEnabled(true);
        $dompdf = new Dompdf($options);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('generate_pdf/evalByEvaluation.html.twig', [
            'dompdf' => $dompdf->getOptions()->getDefaultFont(),
            'themes' => $themes,
//            'evalsByStudent' => $evalsByStudent,
            'evaluation' => $evaluation,
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // Render the HTML as PDF
        $dompdf->render();

        // the file's name
        $name = 'evaluation_' . $evaluation->getName() . '.pdf';
        // Output the generated PDF to Browser (inline view)
        $dompdf->stream($name, [
            "Attachment" => false
        ]);
    }}
