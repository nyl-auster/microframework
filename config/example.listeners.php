<?php
/**
 * @file
 * Define a list of listeners for defined events
 * Rename to listeners.php file to use
 */

// example listener : $listener[event name][callable name]
$listeners['okc.bootstrap']['mymodule.hello'] = array(
  'callable' => 'vendorName\moduleName\className::methodName',
  'enable' => TRUE, // set to false to disabled this event subscriber
);

// you may include your listeners directly from your custom bundle instead.
#include "bundles/vendorName/bundleName/config/listeners.php";

