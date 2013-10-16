<?php
use microframework\core\controller;

$environment = 'dev';

// include routes and settings
//'' @TODO include settings by environment
if (is_readable('routes.php')) include 'routes.php';
if (is_readable('settings.php')) include "settings-$environment.php";

// autoloader PSR-0. Use vendor directory to look for the requested class.
set_include_path("modules:vendor");
spl_autoload_register(function($class){ 
  $path = preg_replace('#\\\|_(?!.+\\\)#','/',$class).'.php'; 
  include_once($path);
}); 

// connect to mysql database if any
// @TODO use pdo instead
if (isset($settings['mysql'])) {
  $mysqlLink = mysql_connect($settings['mysql']['server'], $settings['mysql']['user'], $settings['mysql']['password'])
    or die("Impossible de se connecter : " . mysql_error());
  mysql_select_db($settings['mysql']['database']);
}

// execute current requested path
$controller = new controller($environment, $routes);
print $controller->execute($controller->getRequestedPath());

if (isset($mysqlLink)) { 
  mysql_close($mysqlLink);
}

