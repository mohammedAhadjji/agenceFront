<?php

namespace App\Service;

use DateTime;
use PHPUnit\Util\Json;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CallApiService
{
    
    private $params;
    private $port;
    private $client;
    private $key;

    public function __construct(HttpClientInterface $client,ParameterBagInterface $params)
    {
        $this->port =  'http://localhost:8001';
        $this->params = $params;
        $this->key = $params->get('app.some_global_parameter');
        $this->client = $client;
    }
    //cette methode just pour le test en vas suppreme apré
    public function get():string
    {
        return $this->key;
    }
    public function getData(string $department): array
    {
        return $this->getApi($department);
    }
    public function postData(string $department,$val): array
    {
        return $this->postApi($department,$val);
    }

    private function getApi(string $var )
    {

        $response = $this->client->request(
            'GET',
            $this->port . $var
        );

        return $response->toArray();
    }
    private function postApi( $str ,$var )
    {

       $response = $this->client->request('POST', $this->port.$str, $var);

        return $response->toArray();
    }
    
}
