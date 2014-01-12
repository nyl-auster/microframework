<?php
namespace okc\packages; 

/**
 * List existing packages and bring back us some information about them.
 */
class packages {

  protected $packagesDirectory = '';
  static $packages;

  /**
   * @param string $packagesDirectory
   *   name of directory containing all packages
   * @param array $enabledPackages
   *   List of enabled packages.
   */
  function __construct($packagesDirectory) {
    $this->packagesDirectory = $packagesDirectory;
  }

  /**
   */
  function getList($enabledOnly = FALSE) {

    // static cache for packages.
    if (!empty(self::$packages[(int)$enabledOnly])) {
      return self::$packages[(int)$enabledOnly];
    }

    // scan vendors
    if ($directoryVendors = opendir($this->packagesDirectory)) {
      while (FALSE !== ($vendor = readdir($directoryVendors))) {
        if (!in_array($vendor, array('.', '..'))) {

          // scan packages
          if ($directoryPackage = opendir("$this->packagesDirectory/$vendor")) {
            while (FALSE !== ($package = readdir($directoryPackage))) {
              if (!in_array($package, array('.', '..'))) {

                $packageId = "$vendor.$package";

                $metadatas = array();
                if (is_readable("$this->packagesDirectory/$vendor/$package/config/package.php")) {
                  $metadatas = include "$this->packagesDirectory/$vendor/$package/config/package.php";
                }

                $packages[$packageId] = array(
                  'package' => $package,
                  'vendor' => $vendor,
                  'path' => "$this->packagesDirectory/$vendor/$package",
                );

              }
            }
          } // end scan each vendor directory


        }
      }
    } // end scan packages directory

    closedir($directoryPackage);
    closedir($directoryVendors);
    return self::$packages[(int)$enabledOnly] = $packages;
  }

}

