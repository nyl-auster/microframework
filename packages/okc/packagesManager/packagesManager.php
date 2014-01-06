<?php
namespace okc\packagesManager; 

/**
 * Get informations about packages
 *
 * Packages contains at least two level of directories
 * - level 1 : vendor name
 * - level 2 : package name
 */
class packagesManager {

  protected $packagesDirectory = '';
  protected $packageConfigDirectory = '';

  /**
   * @param string $packagesDirectory
   *   name of directory containing all packages
   * @param string $packageConfigDirectory
   *   name of directory containing config files inside each packages
   */
  function __construct($packagesDirectory, $packageConfigDirectory) {
    $this->packagesDirectory = $packagesDirectory;
    $this->packageConfigDirectory = $packageConfigDirectory;
  }

  /**
   * Return array of instancied module object, if they are "enabled".
   * @param list_disabled (bool)
   * if TRUE, list also disabled modules.
   */
  function getList($list_disabled = FALSE) {

    // static cache for packages.
    if (!empty($packages)) {
      return $packages;
    }

    static $packages = array();

    // scan vendors
    if ($directoryVendors = opendir($this->packagesDirectory)) {
      while (FALSE !== ($vendor = readdir($directoryVendors))) {
        if (!in_array($vendor, array('.', '..'))) {

          // scan packages
          if ($directoryPackage = opendir("$this->packagesDirectory/$vendor")) {
            while (FALSE !== ($package = readdir($directoryPackage))) {
              if (!in_array($package, array('.', '..'))) {

                $packages[$package] = array(
                  'name' => $package,
                  'vendor' => $vendor,
                  'path' => "$this->packagesDirectory/$vendor/$package",
                  'configFiles' => array(),
                );

                // scan packages files.
                if (is_readable("$this->packagesDirectory/$vendor/$package/$this->packageConfigDirectory")) {
                  if ($directoryPackageConfig = opendir("$this->packagesDirectory/$vendor/$package/$this->packageConfigDirectory")) {
                    while (FALSE !== ($configFile = readdir($directoryPackageConfig))) {
                      if (!in_array($configFile, array('.', '..'))) {
                        $packages[$package]['configFiles'][$configFile] = "$this->packagesDirectory/$vendor/$package/$this->packageConfigDirectory/$configFile";

                      }
                    }
                    closedir($directoryPackageConfig);
                  } // end scan each package config directory
                }


              }
            }
          } // end scan each vendor directory


        }
      }
    } // end scan packages directory

    closedir($directoryPackage);
    closedir($directoryVendors);
    return $packages;
  }

}

