<?php

namespace App\Controller;

use App\Service\CallApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class DistinationController extends AbstractController
{
    private $client;
   
    private $CallApiService;

    public function __construct(HttpClientInterface $client,CallApiService $CallApiService)
    {
        $this->client = $client;
      $this->CallApiService = $CallApiService;
    }
    #[Route('/distination', name: 'app_distination')]
    public function index(): Response
    {
       // $response2 = $this->client->request('GET', 'http://localhost:8001/api/destinations');
        $destination = $this->CallApiService->getData('/api/destinations');
        return $this->render('distination/index.html.twig', [
            "destination" => $destination['hydra:member'],
        ]);
    }
}
