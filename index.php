<?php
use okc\framework\httpResourceServer;
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

// instanciate events manager with our listeners configuration
$eventsManager = eventsManager::getInstance($listeners);
$eventsManager->fire('okc.bootstrap', array('routes' => $routes, 'settings' => $settings, 'listeners' => $listeners));

// fetch resource matching current url
$server = new httpResourceServer($routes, $eventsManager);
$resource = $server->getResource($server->getRouteFromUrl());
print $resource->render();

$eventsManager->fire('okc.shutdown');

