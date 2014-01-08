<?php
use okc\server\server;
use okc\eventsManager\eventsManager;

$containerSettings = array(
 'packagesManager' => array(
   'class' => 'okc\packageManager\packageManager',
   'contruct' => array(
     'packages' => 'packages',
     'config' => 'config',
   ),
);

$container = new container();
$container->getService('packageManager'

// set autoloader PSR-0 
set_include_path(implode(PATH_SEPARATOR, array(get_include_path(), 'packages', 'vendors')));
spl_autoload_register(function($class){include_once preg_replace('#\\\|_(?!.+\\\)#','/',$class).'.php';}); 

// now app can fire events calling fire static method.
eventsManager::fire('frameworkBootstrap');

// fetch resource matching current url
$server = new server();
$resource = $server->getResource($server->getRouteFromUrl());
print $resource->render();

eventsManager::fire('frameworkShutdown');

