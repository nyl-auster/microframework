<?php
namespace microframework\core;

class events {

  static protected $listeners = array();
  static protected $instance = null;

  private function __construct($listeners) {
    self::$listeners = $listeners;
  }

  static function getListeners() {
    return self::$listeners;
  }

  static function getInstance($listeners) {
    if (!self::$instance) {
     return new events($listeners);
    }
    return self::$instance;
  }

  /**
   * Dispatch an event in application
   * @event (string)
   *   event name
   * @params (mixed)
   *   param to pass to the listener
   */
  static function fire($event, $params = array()) {
    if (!isset(self::$listeners[$event])) return false;
    foreach (self::$listeners[$event] as $listener) {
      if (isset($listener['enable']) && $listener['enable'] == FALSE)  {
        continue;
      }
      call_user_func_array($listener['callable'], $params);
    }
  }

}

