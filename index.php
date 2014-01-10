<?php
use okc\config\config;
use okc\server\server;
use okc\events\events;
use okc\i18n\i18n;

// add "packages" as an include path.
set_include_path(implode(PATH_SEPARATOR, array(get_include_path(), 'packages')));

// register autoloader.
spl_autoload_register(function($class){
  $file = preg_replace('#\\\|_(?!.+\\\)#','/',$class).'.php';
  if (is_readable("packages/$file")) require_once $file;
}); 

$routes = include 'config/routes.php';
$listeners = include 'config/listeners.php';
$translations = include 'config/translations.php';

// register listeners in events class.
$events = new events($listeners);
$events->fire('frameworkBootstrap');

// register translations in i18n class
new i18n(config::get('okc.i18n:settings'), $translations);

// fetch a resource contant according to current requested Url.
$server = new server($routes);
print $server->getResponse($server->getRouteFromUrl());

$events->fire('frameworkShutdown');

