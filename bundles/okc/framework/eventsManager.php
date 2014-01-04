<?php
/**
 * @file
 * Events Manager
 */
namespace okc\framework;

class eventsManager {

  static protected $instance = null;
  protected $listeners = array();

  /**
   * this is a singleton, see getInstance method.
   */
  private function __construct($listeners) {
    $this->listeners = $listeners;
  }

  /**
   * @param array $listeners
   *   associative array mapping listeners to events. example :
   * $listeners = [
   *   'event.name' = [
   *     'listener.name' = ['callable' => 'my\class::myMethod'],
   *     'listener2.name' = ['callable' => 'my\class::myMethod2'],
   *   ],
   * ];
   */
  static public function getInstance($listeners) {
    if (!self::$instance) {
      self::$instance = new self($listeners);
    }
    return self::$instance;
  }

  static public function getListeners() {
    return $this->listeners;
  }

  /**
   * Call all listeners for a particular event
   * @event (string)
   *   event name
   * @params (mixed)
   *   param to pass to the listener
   */
  public function fire($event, $params = array()) {
    if (!isset($this->listeners[$event])) return false;
    foreach ($this->listeners[$event] as $listener) {
      call_user_func_array($listener['callable'], $params);
    }
  }

}

