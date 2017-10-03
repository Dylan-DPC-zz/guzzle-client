<?php

namespace PHPUnit\Framework;

class initializeTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();
    }

    /** @test **/
	function phpunit_works()
	{
        $this->assertTrue(true);
	}
}