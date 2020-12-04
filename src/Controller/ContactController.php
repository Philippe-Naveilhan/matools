<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     * @return Response
     */
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $contact = new Contact();
        if($this->getUser()) {
            $contact->setUsername($this->getUser()->getUsername());
        }
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = (new Email())
                ->from($contact->getUsername())
                ->to('matools@naveilhan.com')
                ->subject('Mat\'Tools : message de contact')
                ->html($this->renderView('contact/mail.html.twig', [
                    'contact' => $contact,
                ]));

            $mailer->send($email);
            $this->addFlash('success', 'Votre message a bien été envoyé.');
            return $this->redirectToRoute('board');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
            'title' => 'Contact'
        ]);
    }
}
