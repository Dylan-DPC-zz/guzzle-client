<?php
declare(strict_types=1);

namespace Dpc\GuzzleClient;

interface RequestClientContract
{
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
    ): GuzzleClient;

    /**
     * @return GuzzleClient
     */
    public function asFormParams(): GuzzleClient;

    /**
     * @return GuzzleClient
     */
    public function asJson(): GuzzleClient;

    /**
     * @return string
     */
    public function content(): string;

    /**
     * @return array|\stdClass
     */
    public function json();
}
