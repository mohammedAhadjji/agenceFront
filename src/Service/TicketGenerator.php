<?php
namespace App\Service;

use TCPDF;

class TicketGenerator
{
    public function generateTicket($fullName, $email, $address, $amount)
    {
        // Créez une nouvelle instance de TCPDF
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Définissez les informations du document
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Votre nom');
        $pdf->SetTitle('Ticket d\'achat');
        $pdf->SetSubject('Ticket d\'achat');

        // Ajoutez une page
        $pdf->AddPage();

        // Ajoutez le logo de votre site (au format JPG)
        $logoPath = 'assetes/imageApp/logo.jpg'; // Mettez à jour le chemin du logo JPG ici
        $pdf->Image($logoPath, 10, 10, 40, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        // Ajoutez des sauts de ligne
        $pdf->Ln(20);

        // Définissez un style de texte pour le contenu du ticket
        $pdf->SetFont('helvetica', '', 12);

        // Ajoutez le contenu du ticket avec une mise en page personnalisée
        $pdf->SetFillColor(30, 144, 255); // Couleur de fond pour les titres
        $pdf->SetTextColor(255, 255, 255); // Couleur de texte pour les titres
        $pdf->Cell(0, 10, 'Ticket d\'achat', 0, 1, 'C', true);
        $pdf->Ln(10);

        $pdf->SetFillColor(255, 255, 255); // Réinitialiser la couleur de fond
        $pdf->SetTextColor(0, 0, 0); // Réinitialiser la couleur de texte

        $pdf->Cell(0, 10, 'Informations client', 0, 1, 'L');
        $pdf->Cell(0, 10, 'Nom complet: ' . $fullName, 0, 1, 'L');
        $pdf->Cell(0, 10, 'Email: ' . $email, 0, 1, 'L');
        $pdf->Cell(0, 10, 'Adresse: ' . $address, 0, 1, 'L');
        $pdf->Ln(10);

        $pdf->Cell(0, 10, 'Détails de l\'achat', 0, 1, 'L');
        $pdf->Cell(0, 10, 'Montant: $' . $amount, 0, 1, 'L');

        // Renvoyez le PDF en tant que chaîne binaire
        return $pdf->Output('ticket.pdf', 'S');
    }
}