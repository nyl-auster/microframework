<?php
use okc\container\container;

// set autoloader PSR-0 
set_include_path(implode(PATH_SEPARATOR, array(get_include_path(), 'packages', 'vendors')));
spl_autoload_register(function($class){include_once preg_replace('#\\\|_(?!.+\\\)#','/',$class).'.php';}); 

$diParams = array(
  'i18n' => array(
    'default' => array(
      'class' => 'okc\i18n\i18n',
    ),
  ),

  'packagesManager' => array(

    'default' => array(
      'class' => 'okc\packagesManager\packagesManager',
      'arguments' => array(
        'packages' => array('type' => 'int'),
        'config' => array('type' => 'string'),
      ),
    )
  ),
  'server' => array(
    'default' => array(
      'class' => 'okc\server\server',
    ),
  ),

  'resource' => array(
    'default' => array(
      'class' => 'okc\resource\resource',
    ),
  ),

);

$di = new container($diParams);
$pm = $di->get('packagesManager');

$server = $di->get('server');
$resource = $server->getResource($server->getRouteFromUrl());
print $resource->render();

// now app can fire events calling fire static method.
// eventsManager::fire('frameworkBootstrap');

// fetch resource matching current url
// $server = new server();
// $resource = $server->getResource($server->getRouteFromUrl());
// print $resource->render();

// eventsManager::fire('frameworkShutdown');

