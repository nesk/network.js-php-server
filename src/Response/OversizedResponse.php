<?php

namespace NetworkJs\Response;

use NetworkJs\Response;

class OversizedResponse extends Response {

    public function __construct($maxSize, $status = 409, array $headers = [])
    {
        parent::__construct('php://memory', $status, $headers);

        $this->getBody()->write("Conflict: The requested size is superior to the internal limit: $maxSize");
    }

}
