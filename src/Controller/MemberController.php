<?php

namespace App\Controller;

use App\Service\CallApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MemberController extends AbstractController
{
    private $client;
    private $CallApiService;
    public function __construct(HttpClientInterface $client,CallApiService $CallApiService)
    {
        $this->CallApiService = $CallApiService;
        $this->client = $client;
    }


    #[Route('/member', name: 'app_member')]
    public function index(): Response
    {
        //$response = $this->client->request('GET', 'http://localhost:8001/api/team_members');
        $teamMembers = $this->CallApiService->getData('/api/team_members');
       // dd($teamMembers);
        return $this->render('member/index.html.twig', [
            'teamMembers' => $teamMembers['hydra:member'],
        ]);
    }
    #[Route('/member{id<.+>}', name: 'app_member_view')]
    public function view(Request $request, HttpClientInterface $client): Response
    {
        $id = $request->attributes->get('id');
        
        // Récupérer les informations du membre spécifié
      //  $response = $client->request('GET', 'http://localhost:8001'.$id);
        $teamMember = $this->CallApiService->getData($id);
    
      //  $response = $client->request('GET', 'http://localhost:8001/api/team_members');
        $teamMembers = $this->CallApiService->getData('/api/team_members');
       // dd($teamMembers);
        //=$teamMember['hydra:member'];
    
        return $this->render('member/view.html.twig', [
            'member' => $teamMember,
            'teamMembers' => $teamMembers['hydra:member'],
        ]);
    }
    
}
