<?php
use okc\server\server;
use okc\eventsManager\eventsManager;
use okc\packagesManager\packagesManager;

$okc['configDirectory'] = 'config';
$okc['packagesDirectory'] = 'packages';
$okc['vendorsDirectory'] = 'vendors';
$okc['packageConfigDirectory'] = 'config';

$okc['includePath'][] = $okc['packagesDirectory'];
$okc['includePath'][] = $okc['vendorsDirectory'];

$okc['configFiles'][] = 'settings.php';
$okc['configFiles'][] = 'routes.php';
$okc['configFiles'][] = 'listeners.php';
$okc['configFiles'][] = 'translations.php';

// set autoloader PSR-0 
set_include_path(get_include_path() . PATH_SEPARATOR . implode(PATH_SEPARATOR, $okc['includePath']));
spl_autoload_register(function($class){include_once preg_replace('#\\\|_(?!.+\\\)#','/',$class).'.php';}); 

// include config files and instanciate config variables
$_routes = $_settings = $_listeners = $_translations = array();

// load package configuration.
// Cannot remove this from index.php for now, as variable from config files
// must be created in global scope.
$pm = new packagesManager($okc['packagesDirectory'], $okc['packageConfigDirectory']);
$packages = $pm->getList();
foreach ($packages as $package) {
  foreach($package['configFiles'] as $name => $path) {
    if (in_array($name, $okc['configFiles'])) {
      include $path;
    }
  }
}

// load framework global configuration. May override anything set by packages.
foreach ($okc['configFiles'] as $file ) {
  if (is_readable($okc['configDirectory'] . "/$file")) {
    include $okc['configDirectory'] . "/$file";
  }
}

// give all the listeners to eventsManager.
eventsManager::setListeners($_listeners);

// now app can fire events calling fire static method.
eventsManager::fire('frameworkBootstrap', array('routes' => $_routes, 'settings' => $_settings));

// fetch resource matching current url
$server = new server($_routes);
$resource = $server->getResource($server->getRouteFromUrl());
print $resource->render();

eventsManager::fire('frameworkShutdown');

