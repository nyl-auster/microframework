<?php
use microframework\core\controller;

// autoloader PSR-0. Use vendor directory to look for the requested class.
set_include_path("modules:vendor");
spl_autoload_register(function($class){ include preg_replace('#\\\|_(?!.+\\\)#','/',$class).'.php'; }); 

// fetch all our routes
$routes = is_readable('routes.ini') ? parse_ini_file('routes.ini', true) : array();

// execute current requested path
$controller = new controller($routes);
print $controller->executePath($controller->getRequestedPath());

