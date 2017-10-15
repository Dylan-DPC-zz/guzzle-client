<?php

use Dpc\GuzzleClient\GuzzleClient;
use PHPUnit\Framework\TestCase;

class GuzzleClientTest extends TestCase
{
    protected $guzzleClient;

    public static function setUpBeforeClass()
    {
        GuzzleClientServer::start();
    }

    public function setUp()
    {
        $this->guzzleClient = new GuzzleClient();
    }

    function url($url)
    {
        return vsprintf('%s/%s', [
            'http://localhost:'.getenv('TEST_SERVER_PORT'),
            ltrim($url, '/'),
        ]);
    }

    /** @test */
    function a_standard_get_is_working()
    {
        $response = $this->guzzleClient->send('GET', $this->url('/get'), [
            'foo' => 'bar',
            'baz' => 'qux',
        ])->asJson()->json();

        $this->assertEquals([
            'foo' => 'bar',
            'baz' => 'qux',
        ], (array) $response->json);
    }

    /** @test */
    function can_retrieve_the_raw_response_body()
    {
        $response = $this->guzzleClient->send('GET', $this->url('/simple-response'))->content();

        $this->assertEquals("A simple string response", $response);
    }

    /** @test */
    function query_parameters_in_urls_are_respected()
    {
        $response = $this->guzzleClient->send('GET', $this->url('/get?foo=bar&baz=qux'))->json();

        $this->assertEquals([
            'foo' => 'bar',
            'baz' => 'qux',
        ], (array) $response->query);
    }

    /** @test */
    function query_parameters_in_urls_can_be_sent_together_with_array_parameters()
    {
        $response = $this->guzzleClient->send('GET', $this->url('/get?foo=bar'), [
            'baz' => 'qux',
        ])->asJson()->json();

        $this->assertEquals([
            'foo' => 'bar',
        ], (array) $response->query);

        $this->assertEquals([
            'baz' => 'qux',
        ], (array) $response->json);
    }

    /** @test */
    function post_content_can_be_json()
    {
        $response = json_decode($this->guzzleClient->send('POST', $this->url('/post'), [
            'foo' => 'bar',
            'baz' => 'qux',
        ])->asJson()->content(), true);

        $this->assertArraySubset([
            'headers' => [
                'content-type' => ['application/json'],
            ],
            'json' => [
                'foo' => 'bar',
                'baz' => 'qux',
            ],
        ], $response);
    }

    /** @test */
    function post_content_can_be_sent_as_form_params()
    {
        $response = json_decode($this->guzzleClient->send('POST', $this->url('/post'), [
            'foo' => 'bar',
            'baz' => 'qux',
        ])->asFormParams()->content(), true);

        $this->assertArraySubset([
            'headers' => [
                'content-type' => ['application/x-www-form-urlencoded'],
            ],
            'form_params' => [
                'foo' => 'bar',
                'baz' => 'qux',
            ],
        ], $response);
    }

    /** @test */
    function post_content_can_be_sent_as_json_explicitly()
    {
        $response = json_decode($this->guzzleClient->send('POST', $this->url('/post'), [
            'foo' => 'bar',
            'baz' => 'qux',
        ])->asJson()->content(), true);

        $this->assertArraySubset([
            'headers' => [
                'content-type' => ['application/json'],
            ],
            'json' => [
                'foo' => 'bar',
                'baz' => 'qux',
            ],
        ], $response);
    }

    /** @test */
    function get_with_additional_headers()
    {
        $response = json_decode($this->guzzleClient->send('GET', $this->url('/get'), [], ['Custom' => 'Header'])->asJson()->content(), true);

        $this->assertArraySubset([
            'custom' => ['Header'],
        ], $response['headers']);
    }

    /** @test */
    function post_with_additional_headers()
    {
        $response = json_decode($this->guzzleClient->send('POST', $this->url('/post'), [], ['Custom' => 'Header'])->asJson()->content(), true);

        $this->assertArraySubset([
            'custom' => ['Header'],
        ], $response['headers']);
    }

    /** @test */
    function patch_requests_are_supported()
    {
        $response = json_decode($this->guzzleClient->send('PATCH', $this->url('/patch'), [
            'foo' => 'bar',
            'baz' => 'qux',
        ])->asJson()->content(), true);

        $this->assertArraySubset([
            'json' => [
                'foo' => 'bar',
                'baz' => 'qux',
            ],
        ], $response);
    }

    /** @test */
    function put_requests_are_supported()
    {
        $response = json_decode($this->guzzleClient->send('PUT', $this->url('/put'), [
            'foo' => 'bar',
            'baz' => 'qux',
        ])->asJson()->content(), true);

        $this->assertArraySubset([
            'json' => [
                'foo' => 'bar',
                'baz' => 'qux',
            ],
        ], $response);
    }

    /** @test */
    function delete_requests_are_supported()
    {
        $response = json_decode($this->guzzleClient->send('DELETE', $this->url('/delete'), [
            'foo' => 'bar',
            'baz' => 'qux',
        ])->asJson()->content(), true);

        $this->assertArraySubset([
            'json' => [
                'foo' => 'bar',
                'baz' => 'qux',
            ],
        ], $response);
    }

    /** @test */
    function query_parameters_are_respected_in_post_requests()
    {
        $response = json_decode($this->guzzleClient->send('POST', $this->url('/post?banana=sandwich'), [
            'foo' => 'bar',
            'baz' => 'qux',
        ])->asJson()->content(), true);

        $this->assertArraySubset([
            'query' => [
                'banana' => 'sandwich',
            ],
            'json' => [
                'foo' => 'bar',
                'baz' => 'qux',
            ],
        ], $response);
    }

    /** @test */
    function query_parameters_are_respected_in_put_requests()
    {
        $response = json_decode($this->guzzleClient->send('PUT', $this->url('/put?banana=sandwich'), [
            'foo' => 'bar',
            'baz' => 'qux',
        ])->asJson()->content(), true);

        $this->assertArraySubset([
            'query' => [
                'banana' => 'sandwich',
            ],
            'json' => [
                'foo' => 'bar',
                'baz' => 'qux',
            ],
        ], $response);
    }

    /** @test */
    function query_parameters_are_respected_in_patch_requests()
    {
        $response = json_decode($this->guzzleClient->send('PATCH', $this->url('/patch?banana=sandwich'), [
            'foo' => 'bar',
            'baz' => 'qux',
        ])->asJson()->content(), true);

        $this->assertArraySubset([
            'query' => [
                'banana' => 'sandwich',
            ],
            'json' => [
                'foo' => 'bar',
                'baz' => 'qux',
            ],
        ], $response);
    }

    /** @test */
    function query_parameters_are_respected_in_delete_requests()
    {
        $response = json_decode($this->guzzleClient->send('DELETE', $this->url('/delete?banana=sandwich'), [
            'foo' => 'bar',
            'baz' => 'qux',
        ])->asJson()->content(), true);

        $this->assertArraySubset([
            'query' => [
                'banana' => 'sandwich',
            ],
            'json' => [
                'foo' => 'bar',
                'baz' => 'qux',
            ],
        ], $response);
    }

    /** @test */
    function can_retrieve_response_header_values()
    {
        $response = json_decode($this->guzzleClient->send('GET', $this->url('/get'), [])->asJson()->content(), true);

        $this->assertArraySubset([
            'headers' => [
                'content-type' => ['application/json'],
            ],
        ], $response);
    }
}

class GuzzleClientServer
{
    static function start()
    {
        $pid = exec('php -S '.'localhost:'.getenv('TEST_SERVER_PORT').' -t ./tests/server/public > /dev/null 2>&1 & echo $!');

        while (@file_get_contents('http://localhost:'.getenv('TEST_SERVER_PORT').'/get') === false) {
            usleep(1000);
        }

        register_shutdown_function(function () use ($pid) {
            exec('kill '.$pid);
        });
    }
}
