<?php

namespace App\Controller;

use App\Form\ContactFormType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerInterface $mailer): Response
    {

        $form = $this->createForm(ContactFormType::class,null);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $email = (new TemplatedEmail())
            ->from($formData['email'])
            ->to('mohammed.ahadjji@ump.ac.ma')
            ->subject('Subject of the Email')
            ->htmlTemplate('mail/contact.html.twig')
            ->context([
                'name' => $formData['name'],
                'phone' => $formData['phone'],
                'user_email' => $formData['email'], 
                'message' => $formData['message'],
            ]);
        
        $mailer->send($email);
        $this->addFlash('success', 'Votre message a été envoyé avec succès');
        return $this->redirectToRoute('app_contact');
        }
        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
