<?php

namespace NetworkJs;

use Zend\Diactoros\Response as ZendResponse;

class Response extends ZendResponse {

    public function __construct($body = 'php://memory', $status = 200, array $headers = [])
    {
        $headers = array_merge([
            'Access-Control-Allow-Origin' => '*',
            'Connection' => 'close',
        ], $headers);

        parent::__construct($body, $status, $headers);
    }

    public function send()
    {
        http_response_code($this->getStatusCode());

        foreach ($this->getHeaders() as $name => $values) {
            foreach ($values as $value) {
                header("$name: $value", false);
            }
        }

        echo $this->getBody();
    }

}
