<?php

namespace NetworkJs\Response;

use InvalidArgumentException;
use NetworkJs\Response;

class DownloadResponse extends Response {

    public function __construct($size, $content = '-', $status = 200, array $headers = [])
    {
        if (!is_int($size)) {
            throw new InvalidArgumentException('Size must be an integer');
        }

        if (!is_string($content) || empty($content)) {
            throw new InvalidArgumentException('Content must be a non-empty string');
        }

        // The response should never be cached
        $headers = array_merge([
            'Cache-Control' => 'no-cache, no-store, no-transform',
            'Pragma' => 'no-cache', // Support for HTTP 1.0
        ], $headers);

        parent::__construct('php://memory', $status, $headers);

        $this->fillBody($size, $content);
    }

    public function send()
    {
        // Disable gzip compression on Apache configurations
        if (function_exists('apache_setenv')) {
            apache_setenv('no-gzip', '1');
        }

        parent::send();
    }

    private function fillBody($size, $content)
    {
        $body = $this->getBody();

        // Provide a base string which will be provided as a response to the client
        $contentLength = mb_strlen($content);

        // Write the string to the body as much as necessary to reach the required size
        for ($i = 0 ; $i < intval($size / $contentLength) ; $i++) {
            $body->write($content);
        }

        // If necessary complete the response to fully reach the required size
        if (($lastBytes = $size % $contentLength) > 0) {
            $body->write(substr($content, 0, $lastBytes));
        }
    }

}
