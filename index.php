<?php

// autoloader PSR-0. Use vendor and modules directories to look for the requested class.
set_include_path("modules:vendor");
spl_autoload_register(function($class){include_once preg_replace('#\\\|_(?!.+\\\)#','/',$class).'.php';}); 

// include routes and settings
is_readable('routes.php') ? include 'routes.php' : $routes = array();
is_readable('settings.php') ? include "settings.php" : $settings = array();

// @todo pdo.
if (isset($settings['mysql'])) {
  $mysqlLink = mysql_connect($settings['mysql']['server'], $settings['mysql']['user'], $settings['mysql']['password'])
    or die("Impossible de se connecter : " . mysql_error());
  mysql_select_db($settings['mysql']['database']);
}

// fetch resource matching current url
$server = new \microframework\core\server($routes);
$resource = $server->getResource($server->getRouteFromUrl());
print $resource->render();

if (isset($mysqlLink)) {
  mysql_close($mysqlLink);
}

