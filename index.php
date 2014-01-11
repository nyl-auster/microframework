<?php
use okc\config\config;
use okc\server\server;
use okc\events\events;
use okc\i18n\i18n;

$config = include('config/settings.php');

// add in include path PSR directories.
set_include_path(get_include_path() . PATH_SEPARATOR . implode(PATH_SEPARATOR, $config['PSR0Directories']));

// register autoloader.
spl_autoload_register(function($class){ require_once preg_replace('#\\\|_(?!.+\\\)#','/',$class).'.php';});

// instanciate event listener
$events = new events(config::get('listeners'));
$events->fire('frameworkBootstrap');

// instanciate i18n 
new i18n(config::get('okc.i18n.settings'), config::get('translations'));

// serve a resource corresponding to current url.
$server = new server(config::get('routes'));
print $server->getResponse($server->getRouteFromUrl());

$events->fire('frameworkShutdown');

