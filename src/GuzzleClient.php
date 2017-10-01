<?php

namespace Dpc\GuzzleClient;

use GuzzleHttp\Client;
use Dpc\GuzzleClient\RequestClientContract;

class GuzzleClient implements RequestClientContract
{
    protected $client;

    protected $response;

    protected $method;

    protected $uri;

    protected $body;

    protected $headers;

    protected $options;

    protected $format;


    /**
     * GuzzleClient constructor.
     */
    public function __construct()
    {
        $this->client = app(Client::class);
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array  $body    (optional)
     * @param array  $headers (optional)
     * @param array  $options (optional)
     *
     * @return Dpc\GuzzleClient\GuzzleClient
     */
    public function send(string $method, string $uri, array $body = null, array $headers = null, array $options = null)
    {
        [ $this->method, $this->uri, $this->body, $this->headers, $this->options ] = [$method, $uri, $body, $headers, $options];

        return $this;
    }

    /**
     * @return Dpc\GuzzleClient\GuzzleClient
     */
    public function asFormParams()
    {
        $this->format = 'form_params';
        return $this;
    }

    /**
     * @return Dpc\GuzzleClient\GuzzleClient
     */
    public function asJson(): self
    {
        $this->format = 'json';
        return $this;

    }

    /**
     * @return string
     */
    public function content()
    {
        return $this->sendRequest();
    }

    public function json()
    {
        return json_decode($this->sendRequest());
    }

    /**
     * @return string
     */
    protected function sendRequest(): string
    {
        return (string) $this->client->request($this->method, $this->uri, [
            $this->format  => $this->body,
            'headers' => $this->headers,
            'options' => $this->options,
        ])->getBody();
    }
}