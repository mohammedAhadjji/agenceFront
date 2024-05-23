<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OrderService
{
    private $httpClient;
    private $url;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
        $this->url =  'http://localhost:8001';
    }

    public function createOrder($offerId, $numberOfPersons, $totalAmount, array $orderData): array
    {
        // Extraire les données de $orderData
        $clientId = (string) $orderData['clientId'];
        $adress = $orderData['adress'];
        $fullname = $orderData['fullname'];
        $email = $orderData['email'];
    
        // Envoyer la requête POST pour créer la commande
        $response = $this->httpClient->request('POST', $this->url . '/api/orders', [
            'json' => [
                'Offer' => $offerId,
                'numberSeat' => (int) $numberOfPersons,
                'amount' => (int) $totalAmount,
                'status' => 'non payé',
                'clientId' => $clientId,
                'adresse' => $adress,
                'fullname' => $fullname,
                'email' => $email,
            ],
        ]);
    
        // Vérifier le statut de la réponse et retourner le résultat
        if ($response->getStatusCode() === Response::HTTP_CREATED) {
            $order = $response->toArray();
            return ['success' => true, 'order' => $order];
        } else {
            return ['success' => false];
        }
    }
    

    public function getOrder($id): array
    {
        $response = $this->httpClient->request('GET', $this->url."/api/orders/{$id}");
        return $response->toArray();
    }
    public function changeOrderStatus($id, $newStatus): array
    {
        $response = $this->httpClient->request('PATCH', $this->url."/api/orders/{$id}", [
            'headers' => ['Content-Type' => 'application/merge-patch+json'],
            'json' => ['status' => $newStatus],
        ]);

        if ($response->getStatusCode() === Response::HTTP_OK) {
            $order = $response->toArray();
            return ['success' => true, 'order' => $order];
        } else {
            return ['success' => false];
        }
    }
    public function updateOrder(array $orderData): array
{
    // Récupérer l'ID de la commande
    $orderId = $orderData['id']; // Assurez-vous que le tableau contient l'ID de la commande

    // Construire le tableau de données à envoyer dans la requête PATCH
    $data = [
        'clientId' => (int) $orderData['clientId'],
        'adress' => $orderData['adress'],
        'fullname' => $orderData['fullname'],
        'email' => $orderData['email'],
    ];
    
    // Pour déboguer, assurez-vous que les données sont correctes
    // Vous pouvez commenter cette ligne après vérification
    // dd($data);


        $response = $this->httpClient->request('PATCH', $this->url."/api/orders/{$orderId}", [
            'headers' => ['Content-Type' => 'application/merge-patch+json'],
            'json' => ['clientId' => (int) $orderData['clientId'],
            'adress' => $orderData['adress'],
            'fullname' => $orderData['fullname'],
            'email' => $orderData['email']],
        ]);

        if ($response->getStatusCode() === Response::HTTP_OK) {
            $order = $response->toArray();
            return ['success' => true, 'order' => $order];
        } else {
            return ['success' => false];
        }


    
}
}