<?php

use NetworkJs\Response\LatencyResponse;

class LatencyResponseTest extends PHPUnit_Framework_TestCase {

    public function testStatus()
    {
        $response = new LatencyResponse;
        $this->assertEquals(204, $response->getStatusCode());
    }

    public function testBody()
    {
        $response = new LatencyResponse;
        $this->assertEmpty((string)$response->getBody());
    }

}
