<?php
namespace okc\packages; 

/**
 * List existing packages and bring back us some information about them.
 */
class packages {

  protected $packagesDirectories = '';
  protected static $packages;
  protected $coreVendor;

  /**
   * @param string $packagesDirectories
   *   name of directory containing all packages
   * @param array $enabledPackages
   *   List of enabled packages.
   */
  function __construct($packagesDirectories, $coreVendor = 'okc') {
    $this->packagesDirectories = $packagesDirectories;
    $this->coreVendor = $coreVendor;
  }

  /**
   */
  function getList($enabledOnly = FALSE) {

    // static cache for packages.
    if (!empty(self::$packages[(int)$enabledOnly])) {
      return self::$packages[(int)$enabledOnly];
    }

    foreach($this->packagesDirectories as $packagesDirectory) {

      // scan vendors
      if (!is_dir($packagesDirectory))  continue;

      if ($directoryVendors = opendir($packagesDirectory)) {
        while (FALSE !== ($vendor = readdir($directoryVendors))) {
          if (!in_array($vendor, array('.', '..'))) {

            // scan packages
            if (!is_dir("$packagesDirectory/$vendor")) continue;

            if ($directoryPackage = opendir("$packagesDirectory/$vendor")) {
              while (FALSE !== ($package = readdir($directoryPackage))) {
                if (!in_array($package, array('.', '..'))) {
                  $packages["$vendor.$package"] = array(
                    'package' => $package,
                    'vendor' => $vendor,
                    'path' => "$packagesDirectory/$vendor/$package",
                  );
                }
              }
              closedir($directoryPackage);
            } // end scan each vendor directory

          }
        }
        closedir($directoryVendors);
      } // end scan packages directory

    }
    return self::$packages[(int)$enabledOnly] = $packages;
  }

}

