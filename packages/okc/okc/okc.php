<?php
namespace okc\ioc;

/**
 * Glu all packages together with dic help.
 */
class ioc {

  protected $packages;
  protected $packagesList;

  function __construct(okc\packages\packages $packages) {
    $this->packages = $packages;
    $this->packagesList = $packages->getList();
  }

  function getRoutes() {
    $routes = array();
    // waiting for container system...
    foreach ($this->packagesList as $packageId => $packageDatas) {
      foreach ($packageDatas['configFiles'] as $fileName => $filePath) {

        // merge all route files to one big route.
        if ($fileName == 'routes.php') {
          if (!is_readable($filePath)) continue;
          $fileDatas = include $filePath;
          if ($fileDatas == 1) continue;
          foreach ($fileDatas as $route => $routeDatas) {
            $routes[$route] = $routeDatas;
            $routes[$route]['packageId'] = $packageId;
          }
        }

      }
    }
    return $routes;
  }

  function getListeners() {
    $listeners = array();
    foreach ($this->packagesList as $packageId => $packageDatas) {
      foreach ($packageDatas['configFiles'] as $fileName => $filePath) {

        if ($fileName == 'listeners.php') {
          if (!is_readable($filePath)) continue;
          $fileDatas = include $filePath;
          if ($fileDatas == 1) continue;

          foreach ($fileDatas as $eventName => $eventDatas) {
            foreach ($eventDatas as $listenerName => $listenerDatas) {
              $listeners[$eventName][$listenerName] = $listenerDatas;
            }
          }
        }
        
      }
    }
    return $listeners;
  }

  function getTranslations() {
    $translations = array();
    // waiting for container system...
    foreach ($this->packagesList as $packageId => $packageDatas) {
      foreach ($packageDatas['configFiles'] as $fileName => $filePath) {
        if ($fileName == 'translations.php') {
          if (!is_readable($filePath)) continue;
          $fileDatas = include $filePath;
          if ($fileDatas == 1) continue;
          $translations = $fileDatas;
        }
      }
    }
    return $translations;
  }

}

