<?php

namespace App\Controller;

use App\Service\MailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\MailType;

class MailController extends AbstractController
{
    public function mail(): Response
    {
        $mailerService = new MailerService();
        return $this->render('Contact/contact.html.twig', ['mail' => $mailerService]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function new(Request $request): Response
    {
        $form = $this->createForm(MailType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $form->getData();
            return $this->redirectToRoute('contact');
        }

        return $this->render('Contact/contact.html.twig', [
            "form" => $form ->createView(),
        ]);
    }
}
