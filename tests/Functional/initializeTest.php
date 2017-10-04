<?php

namespace Dpc\GuzzleClient\Tests\Functional;

use Dpc\GuzzleClient\GuzzleClient;
use Dpc\GuzzleClient\Tests\TestBase;

class initializeTest extends TestBase
{
    /** @test **/
	function guzzle_initialize()
	{
        $client = new GuzzleClient();
        $this->assertInstanceOf(GuzzleClient::class, $client);
	}
}