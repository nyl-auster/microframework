<?php
use okc\app\app;

// set autoloader PSR-0 
set_include_path(implode(PATH_SEPARATOR, array(get_include_path(), 'packages', 'vendors')));
spl_autoload_register(function($class){include_once preg_replace('#\\\|_(?!.+\\\)#','/',$class).'.php';}); 

$app = new app();
$app->run();

