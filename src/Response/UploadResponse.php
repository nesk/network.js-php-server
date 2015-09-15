<?php

namespace NetworkJs\Response;

use Zend\Diactoros\Stream;
use NetworkJs\Response;

class UploadResponse extends Response {

    public function __construct($status = 204, array $headers = [])
    {
        $body = new Stream('php://temp', 'r');
        parent::__construct($body, $status, $headers);
    }

}
