<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Form\VilleType;
use App\Service\CallApiService;
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
    private $CallApiService;


    public function __construct(TicketGenerator $ticketGenerator,HttpClientInterface $client,CallApiService $CallApiService)
    {
        $this->CallApiService = $CallApiService;
        $this->client = $client;
        $this->ticketGenerator = $ticketGenerator;
    }
    
    
   
    #[Route('/', name: 'app_main')]
    public function index(): Response
    {
        //$response = $this->CallApiService->getData('/api/team_members' );
       // $response = $this->client->request('GET', 'http://localhost:8001/api/team_members');
       // $response2 = $this->client->request('GET', 'http://localhost:8001/api/destinations');
      //  $response3 = $this->client->request('GET', 'http://localhost:8001/api/services');
        $teamMembers = $this->CallApiService->getData('/api/team_members' );
        $destination = $this->CallApiService->getData('/api/destinations' );
        $services = $this->CallApiService->getData('/api/services' );
      //  dd($services);
        return $this->render('main/index.html.twig', [
            'teamMembers' => $teamMembers['hydra:member'],
            "destination" => $destination['hydra:member'],
            "services" => $services['hydra:member']
        ]);
    }

}
