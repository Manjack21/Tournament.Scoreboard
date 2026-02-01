<?php

namespace Tournament\Tournaments;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class RouteHandler
{

    public static function getTournaments(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $response;
    }
}