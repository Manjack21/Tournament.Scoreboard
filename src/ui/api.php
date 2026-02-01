<?php
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../autoload.php';

$container = new Container();
AppFactory::setContainer($container);
$app = AppFactory::create();

// Add authorization
$app->add(new \Tournament\Authorization\AuthorizationMiddleware($app->getResponseFactory()));

// Add routing
$app->addRoutingMiddleware();

// Add Error Handling Middleware
$app->addErrorMiddleware(true, false, false);

$app->get('/api.php', function (Request $request, Response $response, $args) {
    $response->withStatus(200);
    return $response;
});

// routes for tournament operations
$app->group('/api.php/tournaments', function(RouteCollectorProxy $group) {
    $group->get('', function($request, $response) { return \Tournament\Tournaments\RouteHandler::getTournaments($request, $response); });
    
});

// routes for maintenance operations
$app->group('/api.php/maintenance', function(RouteCollectorProxy $group) {
    $group->post('/init', function($request, $response) { return \Tournament\Maintenance\RouteHandler::postInit($response); });    
});


$app->run();
