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

    public function createOrder($offerId, $numberOfPersons, $totalAmount): array
    {
       // dd($offerId,$numberOfPersons,$totalAmount);
        $response = $this->httpClient->request('POST', $this->url.'/api/orders', [
            'json' => [
                'Offer' =>  $offerId,
                'numberSeat' =>(int) $numberOfPersons,
                'amount' =>(int) $totalAmount,
                'status' => 'non payé',
            ],
        ]);

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
}
