<?php

namespace NetworkJs\Response;

use Zend\Diactoros\Stream;
use NetworkJs\Response;

class LatencyResponse extends Response {

    /**
     * @param integer $status
     * @param array $headers
     */
    public function __construct($status = 204, array $headers = [])
    {
        $body = new Stream('php://temp', 'r');
        parent::__construct($body, $status, $headers);
    }

}
