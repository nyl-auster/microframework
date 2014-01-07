<?php
/**
 * @file
 * Events Manager
 */
namespace okc\eventsManager;

use  okc\packagesManager\packagesManager;

class eventsManager {

  static function getListeners() {

    $listeners = array();

    // waiting for container system...
    $pm = new packagesManager('packages', 'config');
    $packages = $pm->getList();

    foreach ($packages as $packageId => $packageDatas) {
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

  /**
   * Call all listeners for a particular event
   * @param string $event 
   *   event name
   * @param array $params
   *   variables to pass to the listener
   */
  static function fire($event, $params = array()) {
    $listeners = self::getListeners();
    if (!isset($listeners[$event])) return false;
    foreach ($listeners[$event] as $class => $config) {
      call_user_func_array("$class::$event", $params);
    }
  }

}

