<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class OrderController extends AbstractController
{
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }
    #[Route('/payment', name: 'app_payment')]
    public function index(): Response
    {
        return $this->render('order/index.html.twig', [
            'controller_name' => 'OrderController',
        ]);
    }
    #[Route('/order/create', name: 'app_order_create', methods: ['POST'])]
    public function createOrder(Request $request): Response
    {
        $offerId = $request->request->get('offer_id');
        $numberOfPersons = $request->request->get('number_of_person');
        $totalAmount = $request->request->get('totalamount');

      
        if ($this->getUser() instanceof User) {
            $user = $this->getUser();
            if ($user instanceof User) {
                $orderData['id'] = $user->getId();
                $orderData['fullname'] = $user->getFullName();
                $orderData['clientId'] = $user->getId();
                $orderData['adress'] = $user->getAddress();
                $orderData['email'] = $user->getEmail();
                
                 //dd($orderData['adress']);
                 $response = $this->orderService->createOrder($offerId, $numberOfPersons, $totalAmount,$orderData);
               // $result = $this->orderService->updateOrder($orderData);
            }}
        if ($response['success']) {
            return $this->redirectToRoute('app_order_confirmation', ['id' => $response['order']['id']]);
        } else {
            $this->addFlash('error', 'There was an error creating the order.');
            return $this->redirectToRoute('app_offre_view', ['id' => $offerId]);
        }
    }

    #[Route('/order/confirmation/{id}', name: 'app_order_confirmation')]
    public function orderConfirmation($id): Response
    {
        $order = $this->orderService->getOrder($id);
       
        
      
     // dd($order);
        return $this->render('order/index.html.twig', [
            'order' => $order,
        ]);
    }

  
}
