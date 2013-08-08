<?php

require 'modules/microframework/core/controller.php';
require 'modules/microframework/core/view.php';
$routes = is_readable('routes.ini') ? parse_ini_file('routes.ini', true) : array();
$controller = new controller($routes);
print $controller->executePath($controller->getRequestedPath());

