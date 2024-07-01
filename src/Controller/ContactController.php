<?php

// src/Controller/ContactController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ContactController extends AbstractController
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @Route("/send-email", name="send_email", methods={"POST"})
     */
    public function sendEmail(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        // Récupérer les données du formulaire
        $name = $data['name'];
        $email = $data['email'];
        $phone = $data['phone'];
        $productType = $data['productType'];
        $dimensions = $data['dimensions'];
        $material = $data['material'];
        $projectType = $data['projectType'];
        $address = $data['address'];
        $budget = $data['budget'];
        $message = $data['message'];
        $ownership = $data['ownership'];
        $subject = $data['subject'];

        // Créer le contenu de l'email
        $emailHtml = "
            <p>Nom complet: {$name}</p>
            <p>Email: {$email}</p>
            <p>Numéro de téléphone: {$phone}</p>
            <p>Type de produit: {$productType}</p>
            <p>Dimensions du produit: {$dimensions}</p>
            <p>Matériau préféré: {$material}</p>
            <p>Type de projet: {$projectType}</p>
            <p>Adresse du projet: {$address}</p>
            <p>Budget estimé: {$budget}</p>
            <p>Êtes-vous: {$ownership}</p>
            <p>Message additionnel: {$message}</p>
        ";

        // Envoyer l'email
        try {
            $email = (new Email())
                ->from('contact@parisreno.fr')
                ->to('contact@paris-reno.fr')
                ->subject($subject)
                ->html($emailHtml);

            $this->mailer->send($email);

            return new Response('Email sent successfully', 200);
        } catch (\Exception $e) {
            return new Response('Error sending email: ' . $e->getMessage(), 500);
        }
    }
}
