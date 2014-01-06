<?php
/**
 * @file
 * Events Manager
 */
namespace okc\eventsManager;

class eventsManager {

  static $listeners = array();

  static function setListeners($listeners) {
    self::$listeners = $listeners;
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

