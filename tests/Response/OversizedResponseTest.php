<?php

use NetworkJs\Response\OversizedResponse;

class OversizedResponseTest extends PHPUnit_Framework_TestCase {

    public function testStatus()
    {
        $response = new OversizedResponse(1);
        $this->assertEquals(409, $response->getStatusCode());
    }

    public function testBody()
    {
        $response = new OversizedResponse(1);
        $this->assertNotEmpty((string)$response->getBody());
    }

}
