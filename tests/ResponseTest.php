<?php

use NetworkJs\Response;

class ResponseTest extends PHPUnit_Framework_TestCase {

    public function testStatus()
    {
        $response = new Response;
        $this->assertEquals(200, $response->getStatusCode());

        $response = new Response('php://memory', 400);
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testHeaders()
    {
        $response = new Response;
        $this->assertEquals([
            'Access-Control-Allow-Origin' => ['*'],
            'Connection' => ['close'],
            'Content-Type' => ['text/plain'],
        ], $response->getHeaders());

        $response = new Response('php://memory', 200, [
            'Content-Type' => ['application/json']
        ]);
        $this->assertEquals([
            'Access-Control-Allow-Origin' => ['*'],
            'Connection' => ['close'],
            'Content-Type' => ['application/json'],
        ], $response->getHeaders());
    }

}
