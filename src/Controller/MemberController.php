<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MemberController extends AbstractController
{
    private $client;
    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }


    #[Route('/member', name: 'app_member')]
    public function index(): Response
    {
        $response = $this->client->request('GET', 'http://localhost:8001/api/team_members');
        $teamMembers = $response->toArray();
        //dd($teamMembers);
        return $this->render('member/index.html.twig', [
            'teamMembers' => $teamMembers['hydra:member'],
        ]);
    }
    #[Route('/member{id<.+>}', name: 'app_member_view')]
    public function view(Request $request, HttpClientInterface $client): Response
    {
        $id = $request->attributes->get('id');
        
        // Récupérer les informations du membre spécifié
        $response = $client->request('GET', 'http://localhost:8001'.$id);
        $teamMember = $response->toArray();
    
        // Récupérer la liste de tous les membres (peut-être que cette requête n'est pas nécessaire ici, selon vos besoins)
        $response = $client->request('GET', 'http://localhost:8001/api/team_members');
        $teamMembers = $response->toArray()['hydra:member'];
    
        return $this->render('member/view.html.twig', [
            'member' => $teamMember,
            'teamMembers' => $teamMembers,
        ]);
    }
    
}
