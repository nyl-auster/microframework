<?php
use okc\server\server;
use okc\events\events;
use okc\i18nUrlPrefix\i18nUrlPrefix as i18n;
use okc\settings\settings;

try {

  // set autoloader PSR-0 and tell him to look for classes in "packages" folder.
  set_include_path(implode(PATH_SEPARATOR, array(get_include_path(), 'packages')));
  spl_autoload_register(function($class){
    $file = preg_replace('#\\\|_(?!.+\\\)#','/',$class).'.php';
    if (!is_readable("packages/$file")) {
      throw new okcException("Autoloader error : fail to load $class. Check file exists, is readable and that namespaces and use statements are correctly set.");
    }
    else {
      require_once $file;
    }
  }); 

  $routes = include 'config/routes.php';
  $settings = include 'config/settings.php';
  $listeners = include 'config/listeners.php';
  $translations = include 'config/translations.php';

  if (!($settings)) {
    throw new okcException("No settings found or have been defined.");
  }
  if (!($routes)) {
    throw new okcException("No routes found or have been defined.");
  }
  if (!($translations)) {
    throw new okcException("No translations found or have been defined.");
  }
  if (!($listeners)) {
    throw new okcException("No listeners found or have been defined.");
  }

  // instanciate eventsManager, passing it all registered listeners.
  $events = new events($listeners);

  $i18nSettings = settings::get('okc.i18n');
  i18n::setSettings($i18nSettings);
  i18n::setTranslations($translations);

  if (!($routes)) {
    throw new okcException("No routes found or have been defined.");
  }

  $server = new server($routes, $events);
  print $server->getResponse($server->getRouteFromUrl());
}
catch (Exception $e) {
  echo '<i>' . $e->getFile() . ' line ' . $e->getLine() . ':</i><br/>' . $e->getMessage();
  echo '<pre>';
  echo $e->getTraceAsString();
  echo '</pre>';
}

// events::fire('frameworkShutdown');

class okcException extends Exception {}

