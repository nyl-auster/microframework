<?php
namespace okc\app;

use okc\server\server;
use okc\eventsManager\eventsManager;
use okc\packagesManager\packagesManager;
use okc\configManager\settings;

/**
 * Launch framework
 */
class app {

  function __construct() {

  }


  public function run() {

    // load package configuration.
    // Cannot remove this from index.php for now, as variable from config files
    // must be created in global scope.
    $settings = settings::get('okc.app');
    $pm = new packagesManager($settings['packagesDirectory'], $settings['packageConfigDirectory']);
    $packages = $pm->getList();

    $config = $this->getPackagesConfig($packages);

    // give all the listeners to eventsManager.
    eventsManager::setListeners($config['listeners']);
    
    // now app can fire events calling fire static method.
    eventsManager::fire('frameworkBootstrap', array('routes' => $config['routes']));

    // fetch resource matching current url
    $server = new server($config['routes']);
    $resource = $server->getResource($server->getRouteFromUrl());
    print $resource->render();
    eventsManager::fire('frameworkShutdown');

  }

  protected function getPackagesConfig($packages) {
     
    static $config = array();
    if ($config) return $config;

    $config = array(
      'routes' => array(),
      'translations' => array(), 
      'listeners' => array()
    );

    foreach ($packages as $packageId => $packageDatas) {
      foreach ($packageDatas['configFiles'] as $fileName => $filePath) {

        if (!is_readable($filePath)) continue;
        $fileDatas = include $filePath;
        if ($fileDatas == 1) continue;

        // merge all route files to one big route.
        if ($fileName == 'routes.php') {
          foreach ($fileDatas as $route => $routeDatas) {
            $config['routes'][$route] = $routeDatas;
            $config['routes'][$route]['packageId'] = $packageId;
          }
        }

        if ($fileName == 'translations.php') {
          $config['translations'] = $fileDatas;
        }

        if ($fileName == 'listeners.php') {
          foreach ($fileDatas as $event => $listeners) {
            foreach ($listeners as $listenerName => $listenerDatas) {
              $config['listeners'][$event][$listenerName] = $listenerDatas;
            }
          }
        }

      }
    }
    
    return $config;

  }

}

