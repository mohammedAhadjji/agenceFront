<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ServiceController extends AbstractController
{
    private $client;
   


    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
      
    }
    #[Route('/service', name: 'app_service')]
    public function index(): Response
    {
        $response3 = $this->client->request('GET', 'http://localhost:8001/api/services');
        $services = $response3->toArray();
        return $this->render('service/index.html.twig', [
            "services" => $services['hydra:member']
        ]);
        
    }
    #[Route('/service/{id}', name: 'app_service_view')]
    public function service(): Response
    {
        return $this->render('service/view.html.twig', [
            'controller_name' => 'ServiceController',
        ]);
    }
}
