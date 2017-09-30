<?php

namespace Dpc\GuzzleClient;


interface RequestClientContract
{
    public function send(string $method, string $uri, array $body = null, array $headers = null, array $options = null);

    public function json();

    public function content();

    public function asFormParams();

    public function asJson();
}