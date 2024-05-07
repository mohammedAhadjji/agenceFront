<?php

namespace App\Service;

use DateTime;
use PHPUnit\Util\Json;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CallApiService
{
    
    private $params;

    private $client;

    public function __construct(HttpClientInterface $client,ParameterBagInterface $params)
    {
        $this->params = $params;
        $this->client = $client;
    }

   
    public function getData(string $department): array
    {
        return $this->getApi($department);
    }
    public function postData(string $department,$str): array
    {
        return $this->postApi($department,$str);
    }

    private function getApi(string $var )
    {
       // $value = $this->params->get('app.some_global_parameter');

        $response = $this->client->request(
            'GET',
            'http://localhost:8001' . $var
        );

        return $response->toArray();
    }
    private function postApi( $str ,$var )
    {
       // $value = $this->params->get('app.some_global_parameter');

       $response = $this->client->request('POST', 'http://localhost:8001'.$str, $var);

        return $response->toArray();
    }
    
}
