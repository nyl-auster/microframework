<?php
namespace okc\config;

/**
 * Config api.
 *
 * @FIXME config folder hardcoded.
 *
 * config::get('okc.i18n.settings');
 */
class config {

  static protected $settings = array();

  /**
   * $configFile = "vendorName.packageName.fileName"
   */
  static function get($configFile) {
    if (isset(self::$settings[$configFile])) {
      return self::$settings[$configFile];
    }
    $configFileParts = explode('.', $configFile);
    $configFileName = array_pop($configFileParts);
    $configFileParts[] = 'config';
    $configFileParts[] = $configFileName;
    $configPath = implode(DIRECTORY_SEPARATOR, $configFileParts);

    $configDefault = self::includeFile("$configPath.php");
    $configOverrides = self::includeFile("user/$configPath.php");

    $config = array_merge($configDefault, $configOverrides);

    return self::$settings[$configFile] = $config;
  }

  static function includeFile($path) {
    $include = array();
    if (is_readable($path)) {
      $include = include($path);
    }
    return $include == 1 ? array() : $include;
  }

}

