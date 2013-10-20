<?php
use microframework\core\server;

// include routes and settings
$routes = array();
if (is_readable('routes.php')) include 'routes.php';
if (is_readable('settings.php')) include "settings.php";

// autoloader PSR-0. Use vendor and modules directories to look for the requested class.
set_include_path("modules:vendor");
spl_autoload_register(function($class){include_once preg_replace('#\\\|_(?!.+\\\)#','/',$class).'.php';}); 

// @todo pdo.
if (isset($settings['mysql'])) {
  $mysqlLink = mysql_connect($settings['mysql']['server'], $settings['mysql']['user'], $settings['mysql']['password'])
    or die("Impossible de se connecter : " . mysql_error());
  mysql_select_db($settings['mysql']['database']);
}

// execute current requested path
$server = new server($routes);
$resource = $server->getResourceByRoute(server::getRouteFromUrl());
print $resource->render();

if (isset($mysqlLink)) mysql_close($mysqlLink);

