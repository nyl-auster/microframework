<?php
use okc\okc\okc;
use okc\packages\packages;
use okc\config\config;
use okc\server\server;
use okc\events\events;
use okc\i18n\i18n;

// add "packages" as an include path.
set_include_path(implode(PATH_SEPARATOR, array(get_include_path(), 'packages', 'user', 'user/packages')));

// register autoloader.
spl_autoload_register(function($class){ require_once preg_replace('#\\\|_(?!.+\\\)#','/',$class).'.php';});

$packagesManager = new packages('packages', 'config');

$okc = new okc($packagesManager);

// instanciate configuration
$settings = $okc->invokePackagesConfig('settings');
$config = new config($settings);

// instanciate events manager
$listeners = $okc->invokePackagesConfig('listeners');
$events = new events($listeners);

$events->fire('frameworkBootstrap');

// instanciate translations
$translations = $okc->invokePackagesConfig('translations');
new i18n($translations);

// fetch a resource according to current requested Url.
$routes = $okc->invokePackagesConfig('routes');
$server = new server($routes);
print $server->getResponse($server->getRouteFromUrl());

$events->fire('frameworkShutdown');

