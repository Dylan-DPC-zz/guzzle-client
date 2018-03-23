<?php
declare(strict_types=1);

namespace Dpc\GuzzleClient;

use GuzzleHttp\Client as GuzzleClient;
use Psr\Http\Message\ResponseInterface;

class Client implements RequestInterface
{
    /** @var GuzzleClient */
    protected $client;

    /** @var string */
    protected $uri;

    /** @var null|array */
    protected $body;

    /** @var null|array */
    protected $headers;

    /** @var null|array */
    protected $options;

    /** @var string */
    protected $format = 'json';

    /** @var bool|resource */
    protected $debug = false;

    /**
     * Client constructor.
     */
    public function __construct()
    {
        $this->client = new GuzzleClient();
    }

    /**
     * Create a new Guzzle Client specifying the Base URI.
     *
     * @param string $base_uri
     * @return RequestInterface
     */
    public function make(string $base_uri): RequestInterface
    {
        $this->client = new GuzzleClient(['base_uri' => $base_uri]);

        return $this;
    }

    /**
     * Specify the URI for the Request.
     *
     * @param string $uri
     * @return RequestInterface
     */
    public function to(string $uri): RequestInterface
    {
        $this->uri = $uri;

        return $this;
    }

    /**
     * Specify the payload.
     *
     * @param array|null $body
     * @param array|null $headers
     * @param array|null $options
     * @return RequestInterface
     */
    public function with(?array $body = null, ?array $headers = null, ?array $options = null): RequestInterface
    {
        $this->body = $body;
        $this->headers = $headers;
        $this->options = $options;

        return $this;
    }

    /**
     * Specify the body for the request.
     *
     * @param array|null $body
     * @return RequestInterface
     */
    public function withBody(?array $body = null): RequestInterface
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Specify the headers for the request.
     *
     * @param array|null $headers
     * @return RequestInterface
     */
    public function withHeaders(?array $headers = null): RequestInterface
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * Specify the options for the request.
     *
     * @param array|null $options
     * @return RequestInterface
     */
    public function withOptions(?array $options = null): RequestInterface
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Specify the body to be Form Parameters.
     *
     * @return RequestInterface
     */
    public function asFormParams(): RequestInterface
    {
        $this->format = 'form_params';

        return $this;
    }

    /**
     * Specify the body to be JSON.
     *
     * @return RequestInterface
     */
    public function asJson(): RequestInterface
    {
        $this->format = 'json';

        return $this;
    }

    /**
     * Toggle debugging.
     *
     * @param bool $debug
     * @return $this
     */
    public function debug($debug = true): RequestInterface
    {
        $this->debug = $debug;

        return $this;
    }

    /**
     * Send a GET Request.
     *
     * @return ResponseInterface
     */
    public function get(): ResponseInterface
    {
        return $this->makeRequest();
    }

    /**
     * Send a POST Request.
     *
     * @return ResponseInterface
     */
    public function post(): ResponseInterface
    {
        return $this->makeRequest('POST');
    }

    /**
     * Send a PUT Request.
     *
     * @return ResponseInterface
     */
    public function put(): ResponseInterface
    {
        return $this->makeRequest('PUT');
    }

    /**
     * Send a PATCH Request.
     *
     * @return ResponseInterface
     */
    public function patch(): ResponseInterface
    {
        return $this->makeRequest('PATCH');
    }

    /**
     * Send a DELETE Request.
     *
     * @return ResponseInterface
     */
    public function delete(): ResponseInterface
    {
        return $this->makeRequest('DELETE');
    }

    /**
     * Sends the request.
     *
     * @param string $method
     * @return ResponseInterface
     */
    private function makeRequest(string $method = 'GET'): ResponseInterface
    {
        $requestParameters = [
            $this->format => $this->body,
            'headers' => $this->headers,
            'debug' => $this->debug
        ];

        if ($this->options !== null) {
            $requestParameters = array_merge($requestParameters, $this->options);
        }

        $response = $this->client->request($method, $this->uri, $requestParameters);

        $this->debug = false;

        return $response;
    }
}
