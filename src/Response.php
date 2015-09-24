<?php

namespace NetworkJs;

use Zend\Diactoros\Response as ZendResponse;

class Response extends ZendResponse {

    /**
     * @param string|resource|Psr\Http\Message\StreamInterface $body
     * @param integer $status
     * @param array $headers
     */
    public function __construct($body = 'php://memory', $status = 200, array $headers = [])
    {
        $headers = array_merge([
            'Access-Control-Allow-Origin' => '*',
            'Connection' => 'close',
            'Content-Type' => 'text/plain',
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
