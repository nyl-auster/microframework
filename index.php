<?php
use microframework\core\server;
use microframework\core\events;

// autoloader PSR-0. Use vendor and modules directories to look for the requested class.
set_include_path("modules:vendor");
spl_autoload_register(function($class){include_once preg_replace('#\\\|_(?!.+\\\)#','/',$class).'.php';}); 

// include config files and instanciate config variables
$routes = $settings = $listeners = array();
foreach (array('routes.php', 'settings.php', 'listeners.php') as $file ) {
  if (is_readable("config/$file")) include "config/$file";
}

// instanciate events manager with our listeners configuration
$events = events::getInstance($listeners);
$events::fire('app.bootstrap', array('routes' => $routes, 'settings' => $settings, 'listeners' => $listeners));

// fetch resource matching current url
$server = new server($routes);
$resource = $server->getResource($server->getRouteFromUrl());
print $resource->render();

$events::fire('app.close');

