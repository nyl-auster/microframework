<?php
/**
 * @file
 * Events Manager
 *
 * example :
 * if fooBar class wants to react on "app.bootsrap" events :
 * - register fooBar class as a listener in a listeners.php file
 *   array('appBootstrap' => array('fooBar' => array());
 * Create aapBootstrap method in fooBar class. 
 */
namespace okc\events;

class events {

  static $listeners = array();

  function __construct($listeners) {
    self::$listeners = $listeners;
  }

  function getListeners() {
    return self::$listeners;
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

