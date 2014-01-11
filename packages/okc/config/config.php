<?php
namespace okc\config;

/**
 * Config api.
 *
 * @FIXME config folder hardcoded.
 * @TODO find how to handle variable overrides, we do need this feature to make framework work.
 *
 * config::get('okc.i18n.settings');
 */
class config {

  static protected $settings = array();

  function __construct($settings) {
    self::$settings = $settings;
  }

  function get($key) {
    if (isset(self::$settings)) {
      return self::$settings[$key];
    }
  }

  /**
   * $configFile = "vendorName.packageName.fileName"
  static function get($configFile) {
    if (isset(self::$settings[$configFile])) {
      return self::$settings[$configFile];
    }

    $configFileParts = explode('.', $configFile);
    $configFileName = array_pop($configFileParts);
    $configFileParts[] = 'config';
    $configFileParts[] = $configFileName;
    $configPath = implode(DIRECTORY_SEPARATOR, $configFileParts);
    $config = include("$configPath.php");
    if ($config == 1) {
      $config = array();
    }
    return self::$settings[$configFile] = $config;
  }
  */

}

