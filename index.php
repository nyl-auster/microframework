<?php
use okc\okc\okc;
use okc\packages\packages;
use okc\config\config;
use okc\server\server;
use okc\events\events;
use okc\i18n\i18n;

// add "packages" and "app/packages" in include path, so that PSR-0 autoloader
// inspect those directories.
set_include_path(implode(PATH_SEPARATOR, array(get_include_path(), 'packages', 'app/packages')));

// register our PSR-0 autoloader.
spl_autoload_register(function($class){ require_once preg_replace('#\\\|_(?!.+\\\)#','/',$class).'.php';});

// get our packages list, needed to gathers all settings file.
$packagesManager = new packages(array('packages', 'app/packages'));
$config = new config($packagesManager);
$config->load('settings');

// instanciate events Manager with all declared listeners.
$events = new events($config->load('listeners'));

// instanciate i18n with all declared translations
new i18n($config->load('translations'));

// Let packages do something before server try to fetch a resource.
$events->fire('appBootstrap');

// instanciate the server with all declared routes,
// then find a resource matching the currently requested url.
$server = new server($config->load('routes'));
print $server->getResponse($server->getRouteFromUrl());

// Let packages do something on application shutdown. 
$events->fire('appShutdown');

