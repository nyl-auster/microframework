<?php
use okc\okc\okc;
use okc\packages\packages;
use okc\config\config;
use okc\server\server;
use okc\events\events;
use okc\i18n\i18n;

// add "packages" as an include path.
set_include_path(implode(PATH_SEPARATOR, array(get_include_path(), 'packages', 'app', 'app/packages')));

// register autoloader.
spl_autoload_register(function($class){ require_once preg_replace('#\\\|_(?!.+\\\)#','/',$class).'.php';});

// get packages
$packagesManager = new packages(array('packages', 'app/packages'));

$config = new config($packagesManager);
$config->load('settings');

$events = new events($config->load('listeners'));

new i18n($config->load('translations'));

$events->fire('frameworkBootstrap');

// fetch a resource according to current requested Url.
$server = new server($config->load('routes'));
print $server->getResponse($server->getRouteFromUrl());

$events->fire('frameworkShutdown');

