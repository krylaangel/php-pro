<?php

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes=new RouteCollection();
$routes->add('hello', new Route('/hello/{name}', ['name' => 'World']));
$routes->add('FindSparePart', new Route('/FindSparePart/{licensePlate}', methods: 'GET'));

return $routes;