<?php
namespace okc\configManager;

class settings {

  static protected $settings = array();

  /**
   * $packageId = "vendor.package"
   */
  static function get($packageId, $settingsFileName = 'settings.php') {

    $variableName = NULL;
    $parts = explode(':', $packageId);
    $packageId = $parts[0];
    if (isset($parts[1])) {
      $variableName = $parts[1];
    }

    $parts = explode('.', $packageId); 
    $vendor = $parts[0];
    $package = $parts[1];

    // serve static cache if settings are already in.
    if (isset(self::$settings[$packageId])) {
      if ($variableName) {
        return self::$settings[$packageId][$variableName];
      }
      return self::$settings[$packageId];
    }

    $filePath = "packages/$vendor/$package/config/$settingsFileName";
    // can't read file, abort
    if (!is_readable($filePath)) return;
    $packageSettings = include($filePath);
    // empty file or no return statement, abort.
    if ($packageSettings == 1) return;
    
    self::$settings[$packageId] = $packageSettings;


    if ($variableName) {
      return self::$settings[$packageId][$variableName];
    }
    return self::$settings[$packageId];

  }

}

