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
    if ($directoryVendors = opendir($packagesDirectory)) {
      while (FALSE !== ($vendor = readdir($directoryVendors))) {
        if (!in_array($vendor, array('.', '..', 'README.md'))) {

          // scan packages
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
          } // end scan each vendor directory


        }
      }
    } // end scan packages directory

    closedir($directoryPackage);
    closedir($directoryVendors);

    }

    return self::$packages[(int)$enabledOnly] = $packages;
  }

}

