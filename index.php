<?php
use microframework\core\controller;

// autoloader PSR-0. Use vendor directory to look for the requested class.
set_include_path("modules:vendor");
spl_autoload_register(function($class){ include preg_replace('#\\\|_(?!.+\\\)#','/',$class).'.php'; }); 

// fetch routes and config
$routes = is_readable('routes.ini') ? parse_ini_file('routes.ini', true) : array();
$settings = is_readable('settings.ini') ? parse_ini_file('settings.ini', true) : array();

if (isset($settings['mysql'])) {
  $mysqlLink = mysql_connect($settings['mysql']['server'], $settings['mysql']['user'], $settings['mysql']['password'])
    or die("Impossible de se connecter : " . mysql_error());
}

// execute current requested path
$controller = new controller($routes);
print $controller->execute($controller->getRequestedPath());

if (isset($mysqlLink)) { 
  mysql_close($mysqlLink);
}

