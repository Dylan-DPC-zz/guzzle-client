<?php

namespace Dpc\GuzzleClient;

use GuzzleHttp\Client;
use Dpc\GuzzleClient\RequestClientContract;

class GuzzleClient implements RequestClientContract
{
    protected $client;

    protected $response;

    /**
     * GuzzleClient constructor.
     */
    public function __construct()
    {
        $this->client = app(Client::class);
    }

    public function send(string $method, string $uri, array $body = null, array $headers = null, array $options = null)
    {
        $this->response = $this->client->request($method, $uri, [
            'form_params' => $body,
            'headers' => $headers,
            'options' => $options,
        ])->getBody();
        
        return $this;
    }

    public function content() : string
    {
        return $this->response;
    }

    public function json()
    {
        return json_decode($this->response);
        
    }
    
    

}