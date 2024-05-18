<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    #[Route('/user/edit', name: 'app_user_edit')]
    public function edit(): Response
    {
        return $this->render('user/editprofile.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    #[Route('/user/ListPayment', name: 'app_user_list')]
    public function listPayement(): Response
    {
        return $this->render('user/listpayment.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
