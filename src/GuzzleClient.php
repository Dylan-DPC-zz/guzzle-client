<?php

namespace Dpc\GuzzleClient;

use GuzzleHttp\Client;

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

    protected $debug;

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
     * @param array|null $body
     * @param array|null $headers
     * @param array|null $options
     * @return RequestClientContract
     */
    public function send(string $method, string $uri, array $body = null, array $headers = null, array $options = null): RequestClientContract
    {
        [$this->method, $this->uri, $this->body, $this->headers, $this->options] = [$method, $uri, $body, $headers, $options];

        return $this;
    }

    /**
     * @return RequestClientContract
     */
    public function asFormParams(): RequestClientContract
    {
        $this->format = 'form_params';
        return $this;
    }

    /**
     * @return RequestClientContract
     */
    public function asJson(): RequestClientContract
    {
        $this->format = 'json';
        return $this;

    }

    /**
     * @return string
     */
    public function content(): string
    {
        return $this->sendRequest();
    }

    public function json()
    {
        return json_decode($this->sendRequest());
    }

    /**
     * @param bool|resource $debug
     * @return $this
     */
    public function debug($debug = true) {
        $this->debug = $debug;

        return $this;
    }

    /**
     * @return string
     */
    protected function sendRequest(): string
    {
        $response = (string)$this->client->request($this->method, $this->uri, [
            $this->format => $this->body,
            'headers' => $this->headers,
            'options' => $this->options,
            'debug' => $this->debug
        ])->getBody();

        $this->debug = false;

        return $response;
    }
}
