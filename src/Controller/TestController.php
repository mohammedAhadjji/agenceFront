<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\CallApiService;
use App\Service\TicketGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class TestController extends AbstractController
{
    
    private $client;
    private $CallApiService;
    private $ticketGenerator;
    public function __construct(HttpClientInterface $client,CallApiService $CallApiService,TicketGenerator $ticketGenerator)
    {
        $this->ticketGenerator = $ticketGenerator;
        $this->CallApiService = $CallApiService;
        $this->client = $client;
    }
    #[Route('/app', name: 'app')]
    public function test(Request $request): Response
    {
        // Votre code existant pour récupérer les informations de l'utilisateur
    
        if ($this->getUser()) {
            $user = $this->getUser();
            if ($user instanceof User) {
                // Supposons que vous récupériez l'utilisateur connecté
               
                $fullName = $user->getFullName();//fullName
                $email = $user->getEmail();//email
                $address = $user->getAddress();//address
            } else {
                $user= new User();
            }
            // Récupérer le montant à partir de la session ou d'une autre source
            $amount = 100; // Remplacez ceci par la méthode appropriée pour obtenir le montant
    
            // Générer le ticket en utilisant le service TicketGenerator
            $pdfContent = $this->ticketGenerator->generateTicket($fullName, $email, $address, $amount);
    
            // Retourner le contenu PDF en tant que réponse
            $response = new Response($pdfContent, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="ticket.pdf"'
            ]);
    
            // Forcer le téléchargement automatique du fichier PDF dans le navigateur
            $response->headers->set('Content-Disposition', 'attachment; filename="ticket.pdf"');
            $response = $response->send();
            $response->sendHeaders();
            $response->setContent($pdfContent);
            $response->sendContent();
            
           
            
        } else {
            return $this->redirectToRoute('app_main');
        }
        return $this->render('main/tick.html.twig');
       
    }
    
    #[Route('/tick', name: 'app_tick')]
    public function tick(Request $request): Response
    {
      
       
        return $this->render('main/tick.html.twig');
    }
}
