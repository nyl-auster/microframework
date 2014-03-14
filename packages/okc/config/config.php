<?php
namespace okc\config;

use okc\packages\packages;

/**
 * Config api.
 *
 * use config::get('name') to get a variable
 * from one of all settings.php 
 *
 * See load() method for possible overrides
 */
class config {

  static protected $settings = array();
  static protected $config = array();
  protected $packages = null;

  function __construct(packages $packages) {
    $this->packages = $packages;
  }

  /**
   * Shortcut to get settings var quickly
   */
  static function get($key) {
    return self::$config['settings'][$key];
  }

  /**
   * Get any config var from any file.
   */
  static function getByType($type, $key = null) {
    if ($key) {
      return self::$config[$type][$key];
    }
    return self::$config[$type];
  }

  /**
   * @param string $type
   *   'settings', 'translations', filename without extension
   *
   * Load all conf from framework. Merge variables according to overrides :
   * For the same variable name :
   * - config folder wins over packages config folder
   * - app/config folder wins over both.
   */
  function load($type) {

    $config = array();

    if (isset(self::$config[$type])) {
      return self::$config[$type];
    }

    // first get packages config.
    $config = $this->invokePackagesConfig($type);

    // then look for other settings or overrides in those directories.
    $configFiles = array(
      "config/$type.php",
      "app/config/$type.php",
    );

    // merge all this.
    foreach ($configFiles as $configFile) {
      $configOverrides = array();
      if (is_readable($configFile)) {
        $configInclude = include $configFile;
        if ($configInclude != 1) {
           $configOverrides = $configInclude;
        }
      }
      $config = array_merge($config, $configOverrides);
    }

    return self::$config[$type] = $config;  

  }

  /**
   * Gather all settings (settings.php, translations.php etc...) from packages
   * config folder.
   */
  function invokePackagesConfig($type) {
    $config = array();
    foreach ($this->packages->getList() as $packageId => $packageDatas) {
      $filepath = $packageDatas['path'] . "/config/$type.php";
      if (is_readable($filepath)) {
        $array = include $filepath;
        if ($array != 1) {
          foreach ($array as $key => $value) {
            $config[$key] = $value;
          }
        }
      }
    }
    return $config;
  }

  /**
   * Return the whole config as an bug array.
   */
  function getAll() {
    return self::$config;
  }

}

