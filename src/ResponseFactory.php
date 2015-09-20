<?php

namespace NetworkJs;

use InvalidArgumentException;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\ServerRequestFactory;

class ResponseFactory {

    const MODULE_NAMES = ['latency', 'upload', 'download'];

    static public function fromRequest(ServerRequestInterface $request = null, $maxSize = null)
    {
        $request = $request ?: ServerRequestFactory::fromGlobals();
        $params = $request->getQueryParams();

        return self::fromValues(@$params['module'], @intval($params['size']), $maxSize);
    }

    static public function fromValues($moduleName, $size = null, $maxSize = null)
    {
        if (!is_string($moduleName)) {
            throw new InvalidArgumentException('ModuleName must be a string');
        } else if (!in_array(strtolower($moduleName), self::MODULE_NAMES)) {
            $moduleNames = implode(', ', self::MODULE_NAMES);
            throw new InvalidArgumentException("ModuleName must be one of these values: {$moduleNames}");
        }

        if ($moduleName === 'download' && !is_int($size)) {
            throw new InvalidArgumentException('A size in bytes must be provided for the download module');
        }

        if ($maxSize !== null && !is_int($maxSize)) {
            throw new InvalidArgumentException('MaxSize must be an integer');
        }

        $responseClass = ucfirst(($maxSize === null || $size <= $maxSize) ? $moduleName : 'oversized');
        $responseClass = "NetworkJs\Response\\{$responseClass}Response";

        if ($responseClass == 'NetworkJs\Response\DownloadResponse') {
            return new $responseClass($size);
        } else if ($responseClass == 'NetworkJs\Response\OversizedResponse') {
            return new $responseClass($maxSize);
        } else {
            return new $responseClass;
        }
    }

}
