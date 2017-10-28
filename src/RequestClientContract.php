<?php

namespace Dpc\GuzzleClient;

interface RequestClientContract
{
    /**
     * @param string $method
     * @param string $uri
     * @param array|null $body
     * @param array|null $headers
     * @param array|null $options
     * @return \Dpc\GuzzleClient\RequestClientContract
     */
    public function send(string $method, string $uri, ?array $body = null, ?array $headers = null, ?array $options = null): RequestClientContract;

    /**
     * @return \Dpc\GuzzleClient\RequestClientContract
     */
    public function asFormParams(): RequestClientContract;

    /**
     * @return \Dpc\GuzzleClient\RequestClientContract
     */
    public function asJson(): RequestClientContract;

    /**
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function content(): string;

    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function json();

    /**
     * @param bool|resource $debug
     * @return \Dpc\GuzzleClient\RequestClientContract
     */
    public function debug($debug = true): RequestClientContract;
}