<?php
/**
 * @file
 * Events Manager
 */
namespace okc\framework;

class eventsManager {

  static $listeners = array();

  static function setListeners($listeners) {
    return self::$listeners;
  }

  static function getListeners() {
    return self::$listeners;
  }

  /**
   * Call all listeners for a particular event
   * @event (string)
   *   event name
   * @params array()
   *   param to pass to the listener
   */
  static function fire($event, $params = array()) {
    if (!isset(self::$listeners[$event])) return false;
    foreach (self::$listeners[$event] as $class => $config) {
      call_user_func_array("$class::$event", $params);
    }
  }

}

