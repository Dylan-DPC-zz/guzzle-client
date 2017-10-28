<?php
declare(strict_types=1);

namespace Dpc\GuzzleClient;

use GuzzleHttp\ClientInterface;

class GuzzleClient implements RequestClientContract
{
    /** @var ClientInterface */
    protected $client;

    /** @var string */
    protected $method;

    /** @var string */
    protected $uri;

    /** @var null|array */
    protected $body;

    /** @var null|array */
    protected $headers;

    /** @var null|array */
    protected $options;

    /** @var string */
    protected $format;

    /** @var bool|resource */
    protected $debug;

    /**
     * GuzzleClient constructor.
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @inheritDoc
     */
    public function send(string $method, string $uri, ?array $body = null, ?array $headers = null, ?array $options = null): RequestClientContract
    {
        [$this->method, $this->uri, $this->body, $this->headers, $this->options] = [$method, $uri, $body, $headers, $options];

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function asFormParams(): RequestClientContract
    {
        $this->format = 'form_params';
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function asJson(): RequestClientContract
    {
        $this->format = 'json';
        return $this;

    }

    /**
     * @inheritDoc
     */
    public function content(): string
    {
        return $this->sendRequest();
    }

    /**
     * @inheritDoc
     */
    public function json()
    {
        return json_decode($this->sendRequest());
    }

    /**
     * @inheritDoc
     */
    public function debug($debug = true): RequestClientContract
    {
        $this->debug = $debug;

        return $this;
    }

    /**
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
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
