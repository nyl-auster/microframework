<?php
use okc\framework\server;
use okc\framework\eventsManager;
use okc\framework\packagesManager;

define('OKC_FRAMEWORK_DIRECTORY_CONFIG', 'config');
define('OKC_FRAMEWORK_DIRECTORY_PACKAGES', 'packages');
define('OKC_FRAMEWORK_DIRECTORY_VENDORS', 'vendors');
define('OKC_PACKAGE_DIRECTORY_RESOURCE', 'resources');
define('OKC_PACKAGE_DIRECTORY_VIEW', 'views');
define('OKC_PACKAGE_DIRECTORY_CONFIG', 'config');

// set autoloader PSR-0 and tell him to look into OKC_DIRECTORY_PACKAGES directory for includes.
$includePathes = array(
  get_include_path(),
  OKC_FRAMEWORK_DIRECTORY_PACKAGES, 
  OKC_FRAMEWORK_DIRECTORY_VENDORS,
);
set_include_path(implode(PATH_SEPARATOR, $includePathes));
spl_autoload_register(function($class){include_once preg_replace('#\\\|_(?!.+\\\)#','/',$class).'.php';}); 

// include config files and instanciate config variables
$_routes = $_settings = $_listeners = $_translations = array();
$configFiles = array(
  'settings.php',
  'routes.php',
  'listeners.php',
  'translations.php',
);

// load package configuration.
// Cannot remove this from index.php for now, as variable from config files
// must be created in global scope.
$pm = new packagesManager(OKC_FRAMEWORK_DIRECTORY_PACKAGES, OKC_PACKAGE_DIRECTORY_CONFIG);
$packages = $pm->getList();
foreach ($packages as $package) {
  foreach($package['configFiles'] as $name => $path) {
    if (in_array($name, $configFiles)) {
      include $path;
    }
  }
}

// load framework global configuration. May override anything set by packages.
foreach ($configFiles as $file ) {
  if (is_readable(OKC_FRAMEWORK_DIRECTORY_CONFIG . "/$file")) {
    include OKC_FRAMEWORK_DIRECTORY_CONFIG . "/$file";
  }
}

// instanciate eventsManager with listeners from listeners.php file.
$eventsManager = new eventsManager($_listeners);
// now app can fire events calling this static method.
$eventsManager::fire('frameworkBootstrap', array('routes' => $_routes, 'settings' => $_settings));

// fetch resource matching current url
$server = new server($_routes);
$resource = $server->getResource($server->getRouteFromUrl());
print $resource->render();

$eventsManager::fire('frameworkShutdown');

