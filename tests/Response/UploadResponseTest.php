<?php

use NetworkJs\Response\UploadResponse;

class UploadResponseTest extends PHPUnit_Framework_TestCase {

    public function testStatus()
    {
        $response = new UploadResponse;
        $this->assertEquals(204, $response->getStatusCode());
    }

    public function testBody()
    {
        $response = new UploadResponse;
        $this->assertEmpty((string)$response->getBody());
    }

}
