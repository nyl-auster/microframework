<?php
use microframework\core\controller;

// autoloader PSR-0. Use vendor directory to look for the requested class.
set_include_path("modules:vendor");
spl_autoload_register(function($class){ 
  $path = preg_replace('#\\\|_(?!.+\\\)#','/',$class).'.php'; 
  include_once($path);
}); 

// fetch routes and config
$routes = is_readable('routes.ini') ? parse_ini_file('routes.ini', true) : array();
$settings = is_readable('settings.ini') ? parse_ini_file('settings.ini', true) : array();

// connect to mysql database if any
if (isset($settings['mysql'])) {
  $mysqlLink = mysql_connect($settings['mysql']['server'], $settings['mysql']['user'], $settings['mysql']['password'])
    or die("Impossible de se connecter : " . mysql_error());
  mysql_select_db($settings['mysql']['database']);
}

// execute current requested path
$controller = new controller($routes);
print $controller->execute($controller->getRequestedPath());

if (isset($mysqlLink)) { 
  mysql_close($mysqlLink);
}

