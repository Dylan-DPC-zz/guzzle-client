# What is this?
[![MIT licensed](https://img.shields.io/badge/license-MIT-blue.svg)](./LICENSE)
<a href="https://packagist.org/packages/dpc/guzzle-client"><img src="https://poser.pugx.org/dpc/guzzle-client/v/stable.svg" alt="Latest Stable Version"></a>

A Simple Guzzle Client for a Laravel application

# Requirements
* PHP 7.1 or higher
* Laravel 5.5 or 5.6 

# Installation
Via composer
```bash
$ composer require dpc/guzzle-client
```

# Usage
Inject the contract into the class where you need the client:
```php
/**
 * @var RequestClientContract
 */
protected $client;

/**
 * @param RequestClientContract $client
 */
public function __construct(RequestClientContract $client)
{
    $this->client = $client;
}
```

You can then use the client by first calling make, to set the base URI - and then populating the request.
The client returns a normal PSR ResponseInterface. This means you interact with the response as you would with any Guzzle response.
```php
$client = $this->client->make('https://httpbin.org/');

$client->to('get')->withBody([
	'foo' => 'bar'
])->withHeaders([
	'baz' => 'qux'
])->withOptions([
	'allow_redirects' => false
])->asJson()->get();

echo $response->getBody();
echo $response->getStatusCode();
```

Alternatively, you can include both the body, headers and options in a single call.

```php
$client = $this->client->make('https://httpbin.org/');

$response = $client->to('get')->with([
    'foo' => 'bar'
], [
    'baz' => 'qux'
], [
    'allow_redirects' => false
])->asFormParams()->get();

echo $response->getBody();
echo $response->getStatusCode();
```

The `asJson()` method will send the data using `json` key in the Guzzle request. (You can use `asFormParams()` to send the request as form params).

# Available methods / Example Usage
```php
$client = $this->client->make('https://httpbin.org/');

// Get request
$response = $client->to('brotli')->get();

// Post request
$response = $client->to('post')->withBody([
	'foo' => 'bar'
])->asJson()->post();

// Put request
$response = $client->to('put')->withBody([
	'foo' => 'bar'
])->asJson()->put();

// Patch request
$response = $client->to('patch')->withBody([
	'foo' => 'bar'
])->asJson()->patch();

// Delete request
$response = $client->to('delete?id=1')->delete();


// Headers are easily added using the withHeaders method
$response = $client->to('get')->withHeaders([
	'Authorization' => 'Bearer fooBar'
])->asJson()->get();


// Custom options can be specified for the Guzzle instance
$response = $client->to('redirect/5')->withOptions([
	'allow_redirects' => [
		'max' => 5,
		'protocols' => [
			'http',
			'https'
		]
	]
])->get();

// You can also specify the request method as a string
$response = $client->to('post')->withBody([
	'foo' => 'bar'
])->asJson()->request('post');
```

# Debugging

Using `debug(bool|resource)` before sending a request turns on Guzzle's debugger, more information about that [here](http://docs.guzzlephp.org/en/stable/request-options.html#debug).

The debugger is turned off after every request, if you need to debug multiple requests sent sequentially you will need to turn on debugging for all of them.

**Example**

```php
$logFile = './guzzle_client_debug_test.log';
$logFileResource = fopen($logFile, 'w+');

$client->debug($logFileResource)->to('post')->withBody([
	'foo' => 'random data'
])->asJson()->post();

fclose($logFileResource);
```

This writes Guzzle's debug information to `guzzle_client_debug_test.log`.

# Versioning
This package follows [semver](http://semver.org/). Features introduced & any breaking changes created in major releases are mentioned in [releases](https://github.com/Dylan-DPC/guzzle-client/releases). 

# Support
This package is created as a basic wrapper for Guzzle based on what I needed in a few projects. If you need any other features of Guzzle, you can create a issue here or send a PR to master branch. 

If you need help or have any questions you can:
* [Create an issue here](https://github.com/Dylan-DPC/guzzle-client/issues/new)
* [Send a tweet to @DPC_22](https://twitter.com/DPC_22)
* Email me at dylan.dpc@gmail.com
* DM me on the [larachat](https://larachat.co/) slack team (@Dylan DPC)

# Authors
[Dylan DPC](https://github.com/Dylan-DPC)

# License
[The MIT License (MIT)](LICENSE)

Copyright (c) 2017 Dylan DPC
