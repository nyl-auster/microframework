<?php
use okc\app\app;

// set autoloader PSR-0 
set_include_path(get_include_path() . PATH_SEPARATOR . implode(PATH_SEPARATOR, array('packages', 'vendors')));
spl_autoload_register(function($class){include_once preg_replace('#\\\|_(?!.+\\\)#','/',$class).'.php';}); 

$app = new app();
$app->run();

