<?php

require '../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use LDH\Router;

$router = new Router(
	Request::createFromGlobals()
);

$router->run();


