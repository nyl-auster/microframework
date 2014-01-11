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
    $config = self::includeFile("$configPath.php");
    return self::$settings[$configFile] = $config;
  }

  static function includeFile($path) {
    $include = include($path);
    return $include == 1 ? array() : $include;
  }

}

