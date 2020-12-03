<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Utopia\App;
use Utopia\Swoole\Request;
use Utopia\Swoole\Response;
use Swoole\Http\Server;
use Swoole\Http\Request as SwooleRequest;
use Swoole\Http\Response as SwooleResponse;

require __DIR__ . '/init.php';

foreach (new DirectoryIterator(__DIR__ . '/' . ROUTES) as $fileInfo) {
    if($fileInfo->isDot()) continue;
    require __DIR__ . '/' . ROUTES . '/' . $fileInfo->getFilename();
}

$http = new Server(HOST, PORT);

$http->on('request', function (SwooleRequest $swooleRequest, SwooleResponse $swooleResponse) {
    $request = new Request($swooleRequest);
    $response = new Response($swooleResponse);
    $app = new App(TIME_ZONE);
    try {
        $app->run($request, $response);
    } catch (\Throwable $th) {
        $swooleResponse->end('500: Server Error');
    }
});

$http->start();