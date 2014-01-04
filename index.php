<?php
use okc\framework\server;
use okc\framework\eventsManager;

// autoloader PSR-0. Use bundles directory to load classes
set_include_path("bundles");
spl_autoload_register(function($class){
  $class = preg_replace('#\\\|_(?!.+\\\)#','/',$class).'.php';
  include_once $class;
}); 

// include config files and instanciate config variables
$routes = $settings = $listeners = array();
foreach (array('routes.php', 'settings.php', 'listeners.php') as $file ) {
  if (is_readable("config/$file")) include "config/$file";
}

// instanciate eventsManager with listeners from listeners.php file.
$eventsManager = new eventsManager($listeners);
$eventsManager::fire('frameworkBootstrap', array('routes' => $routes, 'settings' => $settings, 'listeners' => $listeners));

// fetch resource matching current url
$server = new server($routes, $eventsManager);
$resource = $server->getResource($server->getRouteFromUrl());
print $resource->render();

$eventsManager::fire('frameworkShutdown');

