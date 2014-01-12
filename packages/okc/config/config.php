<?php
namespace okc\config;

use okc\packages\packages;

/**
 * Config api.
 * config::get($type, $name');
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
  function get($key) {
    return self::$config['settings'][$key];
  }

  function getByType($type, $key = null) {
    if ($key) {
      return self::$config[$type][$key];
    }
    return self::$config[$type];
  }

  /**
   * @param string $type
   *   'settings', 'translations', filename without extension
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
      "user/config/$type.php",
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

  function getAll() {
    return self::$config;
  }

}

