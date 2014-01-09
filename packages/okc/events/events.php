<?php
/**
 * @file
 * Events Manager
 */
namespace okc\events;

use  okc\packages\packages;

class events {

  protected static $listeners = array();

  static function setListeners($listeners) {
    self::$listeners = $listeners;
  }

  /**
   * Call all listeners for a particular event
   * @param string $event 
   *   event name
   * @param array $params
   *   variables to pass to the listener
   */
  static function fire($event, $params = array()) {
    if (!isset(self::$listeners[$event])) return false;
    foreach (self::$listeners[$event] as $class => $config) {
      call_user_func_array("$class::$event", $params);
    }
  }

}

