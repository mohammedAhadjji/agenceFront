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
        return $this->render('member/index.html.twig', [
            'teamMembers' => $teamMembers['hydra:member'],
        ]);
    }
    #[Route('/member/{id}', name: 'app_member_view')]
    public function view(Request $request): Response
    {
        $id=$request->attributes->get('id');
        $response = $this->client->request('GET', 'http://localhost:8001/api/team_members'.$id);
        $teamMembers = $response->toArray();
        return $this->render('member/index.html.twig', [
            'teamMember' => $teamMembers,
        ]);
    }
}
