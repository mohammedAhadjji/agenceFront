<?php

namespace App\Controller;

use App\Service\CallApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ServiceController extends AbstractController
{
    private $client;
   private $CallApiService;


    public function __construct(HttpClientInterface $client,CallApiService $CallApiService)
    {
        $this->CallApiService = $CallApiService;
        $this->client = $client;
      
    }
    #[Route('/service', name: 'app_service')]
    public function index(): Response
    {
        //$response3 = $this->client->request('GET', 'http://localhost:8001/api/services');
        $services = $this->CallApiService->getData('/api/services');
        return $this->render('service/index.html.twig', [
            "services" => $services['hydra:member']
        ]);
        
    }
    #[Route('/service/{id}', name: 'app_service_view')]
    public function service(Request $request): Response
    {
        $id = $request->attributes->get('id');
       // $response = $this->client->request('GET', 'http://localhost:8001/api/services/'. $id);
        $service = $this->CallApiService->getData('/api/services/'. $id);
       // $response3 = $this->client->request('GET', 'http://localhost:8001/api/services');
        $services = $this->CallApiService->getData('/api/services');
        return $this->render('service/view.html.twig', [
            "services" => $services['hydra:member'],
            "service" => $service
        ]);
    }
}
