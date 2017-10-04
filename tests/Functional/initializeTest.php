<?php

namespace Dpc\Tests\Functional;

use Dpc\GuzzleClient\GuzzleClient;
use Dpc\Tests\TestBase;

class initializeTest extends TestBase
{
    /** @test **/
	function guzzle_initialize()
	{
        $client = new GuzzleClient();
        $this->assertInstanceOf(GuzzleClient::class, $client);
	}
}