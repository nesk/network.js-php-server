# PHP server for Network.js

A server implementation written in PHP for Network.js. Available as a standalone archive or as a library based on [the PSR-7 standard](http://www.php-fig.org/psr/psr-7/).

## Usage

### As a standalone project

Download the project as a ZIP file and copy it wherever you want on your web server. Then, specify the server URL to the Network.js client:

```js
new Network({
    endpoint: 'path/to/the/server/directory/index.php'
});
```

#### Side note for non-Apache users

This server implementation is configured to disable GZIP compression on Apache but not for other web servers. You must disable this feature for the endpoint used by Network.js or the measures will fail.

### As a library

Since this project is based on [the PSR-7 standard](http://www.php-fig.org/psr/psr-7/), you can use it in “vanilla PHP”, Symfony, Laravel, etc…

```shell
composer require network-js/php-server
```

You can use the `NetworkJs\ResponseFactory` class to generate responses:

```php
use NetworkJs\ResponseFactory;
```

The `fromRequest` method returns a response based on the "module" and "size" query parameters written in the PSR-7 request you provide (if you omit this parameter, a default request will be generated).
It is also recommended to provide a maximum size (in bytes) for the download response, it avoids to overload your server if a client asks for a very big size.

```php
$response = ResponseFactory::fromRequest(
    $request, // An object implementing `Psr\Http\Message\ServerRequestInterface`
    1024 * 1024 * 512 // A maximum size of 512MB
);
```

The `fromValues` method is nearly the same as `fromRequest` but you manually provide the module name (`latency`, `upload` or `download`) and the size (in bytes).

```php
$response = ResponseFactory::fromValues(
    'download',
    1024 * 1024 * 50, // A size of 50MB
    1024 * 1024 * 512 // A maximum size of 512MB
);
```

The returned object is a child instance of the `NetworkJs\Response` class, which provides a `send` method.

```php
$response->send();
```
