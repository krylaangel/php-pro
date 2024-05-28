<?php
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes=new RouteCollection();
$routes->add('part', new Route('/part/{licensePlate}', methods: 'GET'));
return $routes;
