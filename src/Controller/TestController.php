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
       
            $fullName = $this->getUser()['fullName'];
            $email =  $this->getUser()['email'];
            $address = $this->getUser()['address'];
    
            $amount = 100;
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
            
            // Ensuite, effectuez une redirection JavaScript vers la route /tick
            
        } else {
            return $this->redirectToRoute('app_main');
        }
        return $this->render('main/tick.html.twig');
        // Reste du code non exécuté après le retour de la réponse
    }
    
    #[Route('/tick', name: 'app_tick')]
    public function tick(Request $request): Response
    {
        
        return $this->render('main/tick.html.twig');
    }
}
