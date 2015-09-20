<?php

namespace NetworkJs\Response;

use NetworkJs\Response;

class OversizedResponse extends Response {

    public function __construct($maxSize = null, $status = 409, array $headers = [])
    {
        parent::__construct('php://memory', $status, $headers);
        $body = $this->getBody();
        $body->write("Conflict: The requested size is superior to the internal limit");

        if ($maxSize !== null) {
            $body->write(" ($maxSize)");
        }
    }

}
