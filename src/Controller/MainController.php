<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Form\VilleType;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Console\Descriptor\Descriptor;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MainController extends AbstractController
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }
    #[Route('/', name: 'app_main')]
    public function index(): Response
    {
        $response = $this->client->request('GET', 'http://localhost:8001/api/team_members');
        $response2 = $this->client->request('GET', 'http://localhost:8001/api/destinations');
        $teamMembers = $response->toArray();
        $destination = $response2->toArray();

        return $this->render('main/index.html.twig', [
            'teamMembers' => $teamMembers['hydra:member'],
            "distination" => $destination['hydra:member']
        ]);
    }

   #[Route('/test', name: 'app_test')]
    public function test(Request $request): Response
    {
        $form = $this->createForm(VilleType::class);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            dd($data);
        }
        return $this->render('main/test.html.twig', [
            'form' => $form->createView(),
        ]);
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
