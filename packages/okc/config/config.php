<?php
namespace okc\config;

/**
 * Config api.
 *
 * @FIXME packages and config hardcoded.
 * @TODO should be able to load all type of files, not only settings.php
 * @TODO find how to handle variable overrides, we do need this feature to make framework work.
 *
 * config::get('okc.i18n.settings');
 */
class config {

  static protected $settings = array();

  /**
   * $packageId = "vendorName.packageName"
   */
  static function get($packageId) {

    $variableName = NULL;
    $parts = explode(':', $packageId);
    $packageId = $parts[0];
    if (isset($parts[1])) {
      $fileName = $parts[1];
    }

    $parts = explode('.', $packageId); 
    $vendor = $parts[0];
    $package = $parts[1];

    // serve static cache if settings are already in.
    if (isset(self::$settings[$packageId])) {
      return self::$settings[$packageId];
    }

    $filePath = "packages/$vendor/$package/config/$fileName.php";
    // can't read file, abort
    if (!is_readable($filePath)) {

    }

    $packageSettings = include($filePath);
    // empty file or no return statement, abort.
    if ($packageSettings == 1) return;
    
    self::$settings[$packageId] = $packageSettings;
    return self::$settings[$packageId];

  }

}

