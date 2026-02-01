<?php

namespace Tournament\Authorization;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;
use Tournament\Configuration;

class AuthorizationMiddleware implements \Psr\Http\Server\MiddlewareInterface
{
    private readonly ResponseFactoryInterface $responseFactory;
    public function __construct(ResponseFactoryInterface $responseFactory) {
        $this->responseFactory = $responseFactory;
    }


    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $target = $request->getMethod() . $request->getRequestTarget();
        $isPublic = in_array($target, Configuration::PUBLIC_URLS, true);
        $authHeader = $request->getHeaderLine("Authorization");

        if(
            $isPublic === true || (
            $authHeader !== null &&
            str_starts_with( strtolower($authHeader), "bearer ") &&
            in_array(substr($authHeader, strlen("bearer ")), \Tournament\Configuration::API_KEYS, true)
            )
        )
        {
            $response = $handler->handle($request);
        }
        else
        {
            $response = $this->responseFactory->createResponse()
                ->withStatus(401, "Unauthorized");
        }

        return $response;
    }

}
