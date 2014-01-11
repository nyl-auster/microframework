<?php
namespace okc\okc;

/**
 * Glu all packages together with dic help.
 */
class okc {

  protected $packages;
  protected $packagesList;
  static $config = array();

  function __construct(\okc\packages\packages $packages) {
    $this->packages = $packages;
    $this->packagesList = $packages->getList();
  }

  /**
   * @param string $type
   *   'settings', 'translations', filename without extension
   */
  function invokePackagesConfig($type) {

    if (isset(self::$config[$type])) {
      return self::$config[$type];
    }

    foreach ($this->packagesList as $packageId => $packageDatas) {
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

    return self::$config[$type] = $config;  

  }

}

