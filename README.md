# What is this?
[![MIT licensed](https://img.shields.io/badge/license-MIT-blue.svg)](./LICENSE)
<a href="https://packagist.org/packages/dpc/guzzle-client"><img src="https://poser.pugx.org/dpc/guzzle-client/v/stable.svg" alt="Latest Stable Version"></a>

A Simple Guzzle Client for a Laravel application

# Requirements
* PHP 7.1 or higher
* [Laravel 5.4 or 5.5](https://laravel.com/)


# Installation
Via composer
```bash
$ composer require dpc/guzzle-client
```
After installation, publish the vendor files by running:
```bash
php artisan vendor:publish --provider="Dpc\GuzzleClient\GuzzleClientServiceProvider"
```
This will create a `guzzle.php` in the `config` directory which will contain:
```php
return [
    'base_uri' => '',
];
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

You can then use the client by:
```php
$this->client->send('POST', 'foo/bar', [
    'foo' => 'random data',
])->asJson()->json());
```

The `asJson()` method will send the data using `json` key in the Guzzle request. (You can use `asFormParams()` to send the request as form params). 

# Versioning
This package follows [semver](http://semver.org/). Features introduced & any breaking changes created in major releases are mentioned in [releases](https://github.com/Dylan-DPC/guzzle-client/releases). 

# Support
This package is created as a basic wrapper for Guzzle based on what I needed in a few projects. If you need any other features of Guzzle, you can create a issue  here or send a PR to master branch. 

If you need help or have any questions you can:
* Create an issue here
* Send a tweet to @DPC_22
* Email me at dylan.dpc@gmail.com
* DM me on the [larachat](https://larachat.co/) slack team (@Dylan DPC)

# Authors
[Dylan DPC](https://github.com/Dylan-DPC)

# License
[The MIT License (MIT)](LICENSE)

Copyright (c) 2017 Dylan DPC
