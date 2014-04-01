<?php

use okc\server\server;

class app {

  protected static $environment = '';
  protected static $vendorsDirectories = ['packages', 'app/packages'];
  protected static $configDirectory = 'config';
  protected static $configTypes = [
    'settings',
    'listeners',
    'routes',
    'translations',
  ];
  protected static $config = [];

  /**
   * Start framework
   * @param string $environment
   */
  public static function run($environment = '') {
    self::setAutoloader();
    self::loadConfig();
    $server = new server(self::getConfig('routes'));
    print $server->getResponse($server->getRouteFromUrl());
  }

  protected static function setAutoloader() {
    set_include_path(get_include_path() . PATH_SEPARATOR . implode(PATH_SEPARATOR, self::$vendorsDirectories));
    spl_autoload_register(function($class){
      $file = preg_replace('#\\\|_(?!.+\\\)#','/',$class).'.php';
      include_once $file;

    });
  }

  public static function setting($name) {
    return self::$config['settings'][$name];
  }

  public static function getConfig($type) {
    return self::$config[$type];
  }

  /**
   * load all config variables
   * @return array
   */
  protected static function loadConfig() {
    $packages = self::getPackagesList();
    foreach ($packages as $packageDatas) {
      foreach (self::$configTypes as $type) {
        $file = $packageDatas['path'] . '/' . self::$configDirectory .'/' . $type . '.php';
        if (!is_readable($file)) continue;
        $configArray = include $file;
        if ($configArray == 1) continue;
        foreach ($configArray as $key => $value) {
          self::$config[$type][$key] = $value;
        }
      }
    }
  }

  public static function getPackagesList() {

    foreach (self::$vendorsDirectories as $vendorsDirectory ) {

      if (!is_dir($vendorsDirectory)) continue;
      $vendorsDirectoryResource = opendir($vendorsDirectory);

      // scan each vendor of this vendor Directory
      while (FALSE !== ($vendor = readdir($vendorsDirectoryResource))) {
        if (in_array($vendor, ['.', '..']) || !is_dir("$vendorsDirectory/$vendor")) continue;
        if (!is_dir("$vendorsDirectory/$vendor")) continue;

        // scan each packages inside this vendor
        $directoryPackageResource = opendir("$vendorsDirectory/$vendor");
        while (FALSE !== ($package = readdir($directoryPackageResource))) {
          if (in_array($package, ['.', '..'])) continue;

          // create a "packageId by vendor + package concatenation
          $packages["$vendor.$package"] = [
            'package' => $package,
            'vendor'  => $vendor,
            'path'    => "$vendorsDirectory/$vendor/$package",
          ];

        }
        closedir($directoryPackageResource);
      }
      closedir($vendorsDirectoryResource);
    }

    return $packages;

  }


}

