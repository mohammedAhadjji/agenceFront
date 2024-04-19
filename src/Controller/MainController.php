<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Form\VilleType;
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

      
        // Make a GET request to fetch team members
        $response = $this->client->request('GET', 'http://localhost:8001/api/team_members');
        $teamMembers = $response->toArray();

        // Make a GET request to fetch destinations
        $response2 = $this->client->request('GET', 'http://localhost:8001/api/destinations');
        $destination = $response2->toArray();

        return $this->render('main/index.html.twig', [
            'teamMembers' => $teamMembers['hydra:member'],
            "distination" => $destination['hydra:member']
        ]);
    }
   /* #[Route('/test', name: 'app_test')]
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
    }*/
    #[Route('/destination/views{id<.+>}', name: 'app_offres')]
    public function offers(Request $request): Response
    {
        $id = $request->attributes->get('id');

        // Effectuer une requête HTTP à l'API pour récupérer les offres liées à la destination
        $response = $this->client->request('GET', 'http://localhost:8001' . $id);
        $content = $response->toArray();

        // Traiter le contenu de la réponse
       
        // Récupérer les détails de la destination
        $destination = $content;
       
       // dd($destination);
      
        // Vous pouvez maintenant utiliser les offres récupérées dans votre vue Twig ou dans d'autres traitements
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
        
        // Effectuer une requête HTTP à l'API pour récupérer les offres liées à la destination
        $response = $this->client->request('GET', 'http://localhost:8001/api/offres/' . $id);
       
        $content = $response->toArray();
//dd($content);
        // Traiter le contenu de la réponse
       
        // Récupérer les détails de la destination
        $offer = $content;
       // dd($destination);
     // dd($destination);
        // Vous pouvez maintenant utiliser les offres récupérées dans votre vue Twig ou dans d'autres traitements
//dd($offers);
        return $this->render('main/offersView.html.twig', [
            'offre' => $offer,
        ]);
    }
}
