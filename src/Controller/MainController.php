<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Form\VilleType;
use App\Service\TicketGenerator;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Console\Descriptor\Descriptor;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MainController extends AbstractController
{
    private $client;
    private $ticketGenerator;


    public function __construct(TicketGenerator $ticketGenerator,HttpClientInterface $client)
    {
        $this->client = $client;
        $this->ticketGenerator = $ticketGenerator;
    }
    #[Route('/', name: 'app_main')]
    public function index(): Response
    {
        $response = $this->client->request('GET', 'http://localhost:8001/api/team_members');
        $response2 = $this->client->request('GET', 'http://localhost:8001/api/destinations');
        $response3 = $this->client->request('GET', 'http://localhost:8001/api/services');
        $teamMembers = $response->toArray();
        $destination = $response2->toArray();
        $services = $response3->toArray();
      //  dd($services);
        return $this->render('main/index.html.twig', [
            'teamMembers' => $teamMembers['hydra:member'],
            "distination" => $destination['hydra:member'],
            "services" => $services['hydra:member']
        ]);
    }


    #[Route('/app', name: 'app')]
    public function test(Request $request): Response
    {
        // Votre code existant pour récupérer les informations de l'utilisateur
    
        if ($this->getUser()) {
            // Supposons que vous récupériez l'utilisateur connecté
            $user = $this->getUser();
            $fullName = $user->getFullName();
            $email = $user->getEmail();
            $address = $user->getAddress();
    
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
            
            // Ensuite, effectuez une redirection JavaScript vers la route /tick
            
        } else {
            return $this->redirectToRoute('app_main');
        }
        // Reste du code non exécuté après le retour de la réponse
    }
    
    
    #[Route('/destination/views{id<.+>}', name: 'app_offres')]
    public function offers(Request $request): Response
    {
        $id = $request->attributes->get('id');
        $response = $this->client->request('GET', 'http://localhost:8001' . $id);
        $content = $response->toArray();
        $destination = $content;
       // dd($destination);
       //dd($offers);
        return $this->render('main/offers.html.twig', [
            'offers' => $destination['offers'],
            'destination' => $destination,
        ]);
    }
    #[Route('/tick', name: 'app_tick')]
    public function tick(Request $request): Response
    {
        
        return $this->render('main/tick.html.twig');
    }
    #[Route('/offer/views/{id}', name: 'app_offre_view')]
    public function offer(Request $request): Response
    {
        $id = $request->attributes->get('id');
        $response = $this->client->request('GET', 'http://localhost:8001/api/offres/' . $id);
       
        $content = $response->toArray();
        $offer = $content;
       // dd($destination);
       // dd($destination);
       //dd($offers);
        return $this->render('main/offersView.html.twig', [
            'offre' => $offer,
        ]);
    }
}
