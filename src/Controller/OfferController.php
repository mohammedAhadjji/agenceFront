<?php

namespace App\Controller;

use App\Service\CallApiService;
use App\Service\TicketGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OfferController extends AbstractController
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
    
    #[Route('/destination/views{id<.+>}', name: 'app_offres')]
    public function offers(Request $request): Response
    {
        $id = $request->attributes->get('id');
       // $response = $this->client->request('GET', 'http://localhost:8001' . $id);
       // $content = $response->toArray();
        $destination = $this->CallApiService->getData($id );
       //dd($destination);
       //dd($offers);
        return $this->render('main/offers.html.twig', [
            'offers' => $destination['offers'],
            'destination' => $destination,
        ]);
    }
    #[Route('/offer/views/{id}', name: 'app_offre_view')]
    public function offer(Request $request): Response
    {
        $id = $request->attributes->get('id');
       // $response = $this->client->request('GET', 'http://localhost:8001/api/offres/' . $id);
       
       // $content = $response->toArray();
        $offer = $this->CallApiService->getData('/api/offres/' . $id );
       // dd($destination);
       // dd($destination);
       //dd($offer);
        return $this->render('main/offersView.html.twig', [
            'offre' => $offer,
        ]);
    }
}
