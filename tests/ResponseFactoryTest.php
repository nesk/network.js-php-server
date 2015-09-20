<?php

use Zend\Diactoros\ServerRequestFactory;
use NetworkJs\ResponseFactory;

class ResponseFactoryTest extends PHPUnit_Framework_TestCase {

    public function testLatencyResponse()
    {
        $expectedClass = 'NetworkJs\Response\LatencyResponse';
        $moduleName = 'latency';

        $this->assertInstanceOf(
            $expectedClass,
            ResponseFactory::fromValues($moduleName)
        );

        $this->assertInstanceOf(
            $expectedClass,
            ResponseFactory::fromRequest(ServerRequestFactory::fromGlobals(null, [
                'module' => $moduleName,
            ]))
        );
    }

    public function testUploadResponse()
    {
        $expectedClass = 'NetworkJs\Response\UploadResponse';
        $moduleName = 'upload';

        $this->assertInstanceOf(
            $expectedClass,
            ResponseFactory::fromValues($moduleName)
        );

        $this->assertInstanceOf(
            $expectedClass,
            ResponseFactory::fromRequest(ServerRequestFactory::fromGlobals(null, [
                'module' => $moduleName,
            ]))
        );
    }

    public function testDownloadResponse()
    {
        $expectedClass = 'NetworkJs\Response\DownloadResponse';
        $moduleName = 'download';

        $this->assertInstanceOf(
            $expectedClass,
            ResponseFactory::fromValues($moduleName, 10)
        );

        $this->assertInstanceOf(
            $expectedClass,
            ResponseFactory::fromRequest(ServerRequestFactory::fromGlobals(null, [
                'module' => $moduleName,
                'size' => 10,
            ]))
        );
    }

    public function testOversizedResponse()
    {
        $expectedClass = 'NetworkJs\Response\OversizedResponse';
        $moduleName = 'download';

        $this->assertInstanceOf(
            $expectedClass,
            ResponseFactory::fromValues($moduleName, 10, 5)
        );

        $this->assertInstanceOf(
            $expectedClass,
            ResponseFactory::fromRequest(ServerRequestFactory::fromGlobals(null, [
                'module' => $moduleName,
                'size' => 10,
            ]), 5)
        );
    }

}
