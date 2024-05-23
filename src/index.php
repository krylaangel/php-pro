<?php

require __DIR__ . '/../vendor/autoload.php';
//require dirname(__DIR__) . '/vendor/autoload.php';


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes=new RouteCollection();
$routes->add('part', new Route('/part/{licensePlate}', methods: 'GET'));

$request = Request::createFromGlobals();

$context = new RequestContext();
$context->fromRequest($request);
$matcher = new UrlMatcher($routes, $context);

//try {
    extract($attributes = $matcher->match($request->getPathInfo()), EXTR_SKIP);
    $handler = require sprintf(__DIR__ . '/actions/%s.php', $_route);
    $response = call_user_func($handler, $request, $attributes);
    if (!$response instanceof Response){
        return new Response(status: Response::HTTP_INTERNAL_SERVER_ERROR);
    }
//} catch (ResourceNotFoundException $exception) {
//    $response = new Response('Not Found', 404);
//} catch (MethodNotAllowedException $exception) {
//    $response = new Response('HTTP method not allowed', 405);
//} catch (Exception $exception) {
//    $response = new Response('An error occurred', 500);
//}
$response->send();
