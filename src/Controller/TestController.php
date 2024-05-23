<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\CallApiService;
use App\Service\OrderService;
use App\Service\TicketGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class TestController extends AbstractController
{
    private $CallApiService;
    private $ticketGenerator;
    private $orderService;
    
    public function __construct(HttpClientInterface $client,CallApiService $CallApiService,TicketGenerator $ticketGenerator,OrderService $orderService)
    {
        $this->ticketGenerator = $ticketGenerator;
        $this->CallApiService = $CallApiService;
        $this->orderService = $orderService;
    }
    #[Route('/app/{id}', name: 'app')]
    public function test(Request $request): Response
    {
        $id = $request->attributes->get('id');
        $order = $this->orderService->getOrder($id);
        // Votre code existant pour récupérer les informations de l'utilisateur changeOrderStatus
        $this->orderService->changeOrderStatus($id,'payée');
        $order = $this->orderService->getOrder($id);
        $orderData  = [];

        if ($this->getUser() instanceof User) {
            $user = $this->getUser();
            if ($user instanceof User) {
                $orderData['id'] = $id;
                $orderData['fullname'] = $user->getFullName();
                $orderData['clientId'] = $user->getId();
                $orderData['adress'] = $user->getAddress();
                $orderData['email'] = $user->getEmail();
                
                 //dd($orderData);
                $result = $this->orderService->updateOrder($orderData);
            

       
            // Récupérer le montant à partir de la session ou d'une autre source
            $amount = $order['amount']; // Remplacez ceci par la méthode appropriée pour obtenir le montant
    

            // Générer le ticket en utilisant le service TicketGenerator
            $pdfContent = $this->ticketGenerator->generateTicket($orderData['fullname'],$orderData['email'] , $orderData['adress'], $amount);
    
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
        }
            
        } else {
            return $this->redirectToRoute('app_main');
        }
        return $this->render('main/tick.html.twig');
       
    }
    
    #[Route('/tick/{id}', name: 'app_tick')]
    public function tick(Request $request, $id): Response
    {
         $id = $request->attributes->get('id'); 


         
        // Change the order status to 'payée'
        $result = $this->orderService->changeOrderStatus($id, 'payée');

      // dd($result);
        return $this->render('main/tick.html.twig', [
            'id' => $id,
        ]);
    }
}
