<?php
use okc\framework\server;
use okc\framework\eventsManager;

define('OKC_FRAMEWORK_DIRECTORY_CONFIG', 'config');
define('OKC_FRAMEWORK_DIRECTORY_PACKAGES', 'packages');
define('OKC_FRAMEWORK_DIRECTORY_VENDORS', 'vendors');
define('OKC_PACKAGE_DIRECTORY_RESOURCE', 'resources');
define('OKC_PACKAGE_DIRECTORY_VIEW', 'views');

// set autoloader PSR-0 and tell him to look into OKC_DIRECTORY_PACKAGES directory for includes.
set_include_path(get_include_path() . PATH_SEPARATOR . OKC_FRAMEWORK_DIRECTORY_PACKAGES . PATH_SEPARATOR . OKC_FRAMEWORK_DIRECTORY_VENDORS);
spl_autoload_register(function($class){include_once preg_replace('#\\\|_(?!.+\\\)#','/',$class).'.php';}); 

// include config files and instanciate config variables
$routes = $settings = $listeners = array();
foreach (array('routes.php', 'settings.php', 'listeners.php') as $file ) {
  if (is_readable(OKC_FRAMEWORK_DIRECTORY_CONFIG . "/$file")) include "config/$file";
}

// instanciate eventsManager with listeners from listeners.php file.
$eventsManager = new eventsManager($listeners);
$eventsManager::fire('frameworkBootstrap', array('routes' => $routes, 'settings' => $settings));

// fetch resource matching current url
$server = new server($routes, $eventsManager);
$resource = $server->getResource($server->getRouteFromUrl());
print $resource->render();

$eventsManager::fire('frameworkShutdown');

