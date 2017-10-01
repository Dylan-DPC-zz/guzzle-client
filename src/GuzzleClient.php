<?php
declare(strict_types=1);

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

    /**
     * GuzzleClient constructor.
     */
    public function __construct()
    {
        $this->client = app(Client::class);
    }

    /**
     * @param string $method  Method to use
     * @param string $uri     Request uri
     * @param array  $body    (optional)
     * @param array  $headers (optional)
     * @param array  $options (optional)
     *
     * @return GuzzleClient
     */
    public function send(
        string $method,
        string $uri,
        array $body = null,
        array $headers = null,
        array $options = null
    ): GuzzleClient {
        [ $this->method, $this->uri, $this->body, $this->headers, $this->options ] = [$method, $uri, $body, $headers, $options];

        return $this;
    }

    /**
     * @return GuzzleClient
     */
    public function asFormParams(): GuzzleClient
    {
        $this->format = 'form_params';

        return $this;
    }

    /**
     * @return GuzzleClient
     */
    public function asJson(): GuzzleClient
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

    /**
     * @return array|\stdClass
     */
    public function json()
    {
        return \json_decode($this->sendRequest());
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
