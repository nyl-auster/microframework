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

  static function fire($event) {
    if (!isset(self::$listeners[$event])) return false;
    foreach (self::$listeners[$event] as $listener) {
      if ($listener['enable']) {
        call_user_func($listener['callable']);
      }
    }
  }

}

