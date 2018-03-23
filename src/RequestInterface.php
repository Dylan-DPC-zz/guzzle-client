<?php

namespace Dpc\GuzzleClient;

use Psr\Http\Message\ResponseInterface;

interface RequestInterface
{
    /**
     * @param string $base_uri
     * @return RequestInterface
     */
    public function make(string $base_uri): RequestInterface;

    /**
     * @param string $uri
     * @return RequestInterface
     */
    public function to(string $uri): RequestInterface;

    /**
     * @param array|null $body
     * @param array|null $headers
     * @param array|null $options
     * @return RequestInterface
     */
    public function with(?array $body = null, ?array $headers = null, ?array $options = null): RequestInterface;

    /**
     * @param array|null $body
     * @return RequestInterface
     */
    public function withBody(?array $body = null): RequestInterface;

    /**
     * @param array|null $headers
     * @return RequestInterface
     */
    public function withHeaders(?array $headers = null): RequestInterface;

    /**
     * @param array|null $options
     * @return RequestInterface
     */
    public function withOptions(?array $options = null): RequestInterface;

    /**
     * @return RequestInterface
     */
    public function asFormParams(): RequestInterface;

    /**
     * @return RequestInterface
     */
    public function asJson(): RequestInterface;

    /**
     * @param bool $debug
     * @return RequestInterface
     */
    public function debug($debug = true): RequestInterface;

    /**
     * @return ResponseInterface
     */
    public function get(): ResponseInterface;

    /**
     * @return ResponseInterface
     */
    public function post(): ResponseInterface;

    /**
     * @return ResponseInterface
     */
    public function put(): ResponseInterface;

    /**
     * @return ResponseInterface
     */
    public function patch(): ResponseInterface;

    /**
     * @return ResponseInterface
     */
    public function delete(): ResponseInterface;
}