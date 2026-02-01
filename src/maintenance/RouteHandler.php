<?php

namespace Tournament\Maintenance;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class RouteHandler
{
    public static function postInit(ResponseInterface $response)
    {
        $db = new \Tournament\Database\Database();
        $db->initialise();

        return $response;
    }
}
