<?php

use NetworkJs\Response\DownloadResponse;

class DownloadResponseTest extends PHPUnit_Framework_TestCase {

    public function testStatus()
    {
        $response = new DownloadResponse(10);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testHeaders()
    {
        $response = new DownloadResponse(10);
        $this->assertArraySubset([
            'Cache-Control' => ['no-cache, no-store, no-transform'],
            'Pragma' => ['no-cache'],
        ], $response->getHeaders());
    }

    public function testBody()
    {
        $response = new DownloadResponse(10);
        $this->assertEquals(10, mb_strlen((string)$response->getBody()));
    }

}
