<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DistinationController extends AbstractController
{
    #[Route('/distination', name: 'app_distination')]
    public function index(): Response
    {
        return $this->render('distination/index.html.twig', [
            'controller_name' => 'DistinationController',
        ]);
    }
}
