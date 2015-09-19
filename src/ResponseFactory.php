<?php

namespace NetworkJs;

use InvalidArgumentException;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\ServerRequestFactory;

class ResponseFactory {

    const DEFAULT_MAX_SIZE = 1024 * 1024 * 200;
    const MODULE_NAMES = ['latency', 'upload', 'download'];

    static public function fromRequest(ServerRequestInterface $request = null, $maxSize = self::DEFAULT_MAX_SIZE)
    {
        $request = $request ?: ServerRequestFactory::fromGlobals();
        $params = $request->getQueryParams();

        return $this->fromValues(@$params['module'], @intval($params['size']), $maxSize);
    }

    static public function fromValues($moduleName, $size, $maxSize = self::DEFAULT_MAX_SIZE)
    {
        if (!is_string($moduleName)) {
            throw new InvalidArgumentException('ModuleName must be a string');
        } else if (!in_array(strtolower($moduleName), self::MODULE_NAMES)) {
            $moduleNames = implode(', ', self::MODULE_NAMES);
            throw new InvalidArgumentException("ModuleName must be one of these values: {$moduleNames}");
        }

        if (!is_int($size)) {
            throw new InvalidArgumentException('Size must be an integer');
        }

        if (!is_int($maxSize)) {
            throw new InvalidArgumentException('MaxSize must be an integer');
        }

        $responseClass = ucfirst($size <= $maxSize ? $moduleName : 'oversized');
        $responseClass = "NetworkJs\Response\\{$responseClass}Response";

        if ($responseClass == 'NetworkJs\Response\DownloadResponse') {
            return new $responseClass($size);
        } else {
            return new $responseClass;
        }
    }

}
